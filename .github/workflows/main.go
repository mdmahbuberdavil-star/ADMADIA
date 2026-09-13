module admadia-tracker

go 1.22

require (
	firebase.google.com/go/v4 v4.14.1
	google.golang.org/api v0.180.0
)package main

import (
	"context"
	"crypto/md5"
	"crypto/rand"
	"encoding/hex"
	"encoding/json"
	"io"
	"log"
	"net"
	"net/http"
	"net/url"
	"os"
	"strconv"
	"strings"
	"time"

	firebase "firebase.google.com/go/v4"
	"firebase.google.com/go/v4/auth"
	"firebase.google.com/go/v4/database"
	"google.golang.org/api/option"
)

const (
	databaseURL = "https://adbluemedia-156b6-default-rtdb.firebaseio.com"
	dedupWindow = 24 * time.Hour
)

type server struct {
	db   *database.Client
	auth *auth.Client
}

func main() {
	ctx := context.Background()

	var opt option.ClientOption
	switch {
	case os.Getenv("FIREBASE_SERVICE_ACCOUNT") != "":
		opt = option.WithCredentialsJSON([]byte(os.Getenv("FIREBASE_SERVICE_ACCOUNT")))
	case os.Getenv("GOOGLE_APPLICATION_CREDENTIALS") != "":
		opt = option.WithCredentialsFile(os.Getenv("GOOGLE_APPLICATION_CREDENTIALS"))
	default:
		opt = option.WithCredentialsFile("serviceAccountKey.json")
	}

	app, err := firebase.NewApp(ctx, &firebase.Config{DatabaseURL: databaseURL}, opt)
	if err != nil {
		log.Fatalf("firebase.NewApp: %v", err)
	}
	db, err := app.Database(ctx)
	if err != nil {
		log.Fatalf("app.Database: %v", err)
	}
	ac, err := app.Auth(ctx)
	if err != nil {
		log.Fatalf("app.Auth: %v", err)
	}

	s := &server{db: db, auth: ac}

	mux := http.NewServeMux()
	mux.HandleFunc("GET /{$}", s.handleHealth)
	mux.HandleFunc("GET /go/{clickId}", s.handleGo)
	mux.HandleFunc("/postback", s.handlePostback)
	mux.HandleFunc("POST /admin/approve-lead", s.requireAdmin(s.handleApproveLead))
	mux.HandleFunc("POST /admin/manual-update", s.requireAdmin(s.handleManualUpdate))

	port := os.Getenv("PORT")
	if port == "" {
		port = "8080"
	}
	log.Printf("AdMadia tracker (Go) listening on :%s", port)
	log.Fatal(http.ListenAndServe(":"+port, mux))
}

// ────────────────────────────────────────────────────────────────
//  Handlers
// ────────────────────────────────────────────────────────────────

func (s *server) handleHealth(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "text/plain")
	io.WriteString(w, "AdMadia tracker OK")
}

func (s *server) handleGo(w http.ResponseWriter, r *http.Request) {
	clickID := r.PathValue("clickId")
	aff := r.URL.Query().Get("aff")   // already URL-decoded by net/url
	dest := r.URL.Query().Get("dest") // already URL-decoded
	if clickID == "" || dest == "" {
		http.Error(w, "missing clickId or dest", http.StatusBadRequest)
		return
	}

	ctx := r.Context()
	now := time.Now().UnixMilli()
	ip := clientIP(r)
	ua := r.UserAgent()
	if len(ua) > 250 {
		ua = ua[:250]
	}

	if key := s.resolveAffiliate(ctx, clickID, aff); key != "" {
		s.recordClick(ctx, key, clickID, aff, ip, ua, now)
	}

	u, err := url.Parse(dest)
	if err != nil {
		http.Error(w, "bad dest", http.StatusBadRequest)
		return
	}
	q := u.Query()
	q.Set("sub6", clickID)
	if aff != "" {
		q.Set("aff_id", aff)
	}
	u.RawQuery = q.Encode()
	http.Redirect(w, r, u.String(), http.StatusFound)
}

func (s *server) handlePostback(w http.ResponseWriter, r *http.Request) {
	ctx := r.Context()
	_ = r.ParseForm()

	clickID := first(r.Form.Get("click_id"), r.Form.Get("clickId"))
	if clickID == "" {
		http.Error(w, "missing click_id", http.StatusBadRequest)
		return
	}
	amount, _ := strconv.ParseFloat(r.Form.Get("payout"), 64)
	status := r.Form.Get("status")
	if status == "" {
		status = "1"
	}
	isConversion := status == "1" || strings.EqualFold(status, "approved")
	leadID := r.Form.Get("lead_id")

	var idx struct {
		AffiliateKey string `json:"affiliateKey"`
	}
	if err := s.db.NewRef("clickIdIndex/"+clickID).Get(ctx, &idx); err != nil || idx.AffiliateKey == "" {
		writeText(w, 200, "unknown click_id")
		return
	}
	key := idx.AffiliateKey

	var rows map[string]map[string]interface{}
	_ = s.db.NewRef("trackings/"+key).
		OrderByChild("clickId").EqualTo(clickID).
		LimitToLast(1).Get(ctx, &rows)

	var eventID string
	var alreadyConverted bool
	for k, v := range rows {
		eventID = k
		if b, ok := v["conversion"].(bool); ok {
			alreadyConverted = b
		}
	}
	if eventID == "" || alreadyConverted || !isConversion {
		writeText(w, 200, "ok")
		return
	}

	_ = s.db.NewRef("trackings/"+key+"/"+eventID).Update(ctx, map[string]interface{}{
		"conversion":  true,
		"earnings":    amount,
		"leadId":      leadID,
		"convertedAt": time.Now().UnixMilli(),
	})

	today := time.Now().UTC().Format("2006-01-02")
	incrementLeads(ctx, s.db, key, today, amount)
	writeText(w, 200, "ok")
}

func (s *server) handleApproveLead(w http.ResponseWriter, r *http.Request) {
	var body struct {
		EvID   string  `json:"evId"`
		AffKey string  `json:"affKey"`
		Amount float64 `json:"amount"`
	}
	if err := json.NewDecoder(r.Body).Decode(&body); err != nil {
		writeJSON(w, 400, map[string]string{"error": "bad body"})
		return
	}
	if body.EvID == "" || body.AffKey == "" {
		writeJSON(w, 400, map[string]string{"error": "evId and affKey required"})
		return
	}
	if body.Amount == 0 {
		body.Amount = 25
	}

	ctx := r.Context()
	_ = s.db.NewRef("trackings/"+body.AffKey+"/"+body.EvID).Update(ctx, map[string]interface{}{
		"conversion":  true,
		"earnings":    body.Amount,
		"convertedAt": time.Now().UnixMilli(),
	})
	today := time.Now().UTC().Format("2006-01-02")
	incrementLeads(ctx, s.db, body.AffKey, today, body.Amount)
	_, _ = s.db.NewRef("leads/" + strconv.FormatInt(time.Now().UnixMilli(), 10)).Push(ctx, map[string]interface{}{
		"clickId":   body.EvID,
		"affiliate": body.AffKey,
		"earnings":  body.Amount,
		"timestamp": time.Now().UnixMilli(),
	})
	writeJSON(w, 200, map[string]bool{"ok": true})
}

func (s *server) handleManualUpdate(w http.ResponseWriter, r *http.Request) {
	var body struct {
		Target string  `json:"target"`
		Amount float64 `json:"amount"`
		Action string  `json:"action"`
	}
	if err := json.NewDecoder(r.Body).Decode(&body); err != nil {
		writeJSON(w, 400, map[string]string{"error": "bad body"})
		return
	}
	if body.Target == "" {
		writeJSON(w, 400, map[string]string{"error": "target required"})
		return
	}
	key := safeKey(body.Target)
	ctx := r.Context()

	_ = s.db.NewRef("users/"+key+"/stats").Transaction(ctx,
		func(n database.TransactionNode) (interface{}, error) {
			cur := map[string]interface{}{}
			_ = n.Unmarshal(&cur)
			switch body.Action {
			case "add_balance":
				cur["earnings"] = toFloat(cur["earnings"]) + body.Amount
			case "add_lead":
				cur["leads"] = toInt(cur["leads"]) + int64(body.Amount)
				cur["earnings"] = toFloat(cur["earnings"]) + body.Amount*25
			}
			return cur, nil
		})
	writeJSON(w, 200, map[string]bool{"ok": true})
}

// ────────────────────────────────────────────────────────────────
//  Firebase helpers
// ────────────────────────────────────────────────────────────────

func (s *server) resolveAffiliate(ctx context.Context, clickID, aff string) string {
	var idx struct {
		AffiliateKey string `json:"affiliateKey"`
	}
	if err := s.db.NewRef("clickIdIndex/"+clickID).Get(ctx, &idx); err == nil && idx.AffiliateKey != "" {
		return idx.AffiliateKey
	}
	if aff == "" {
		return ""
	}
	var users map[string]struct {
		Profile struct {
			FFID string `json:"ffid"`
		} `json:"profile"`
	}
	if err := s.db.NewRef("users").
		OrderByChild("profile/ffid").EqualTo(aff).
		Get(ctx, &users); err != nil {
		return ""
	}
	for k := range users {
		return k
	}
	return ""
}

func (s *server) recordClick(ctx context.Context, key, clickID, aff, ip, ua string, now int64) {
	// Duplicate check within the last 24h.
	cutoff := now - dedupWindow.Milliseconds()
	var recent map[string]struct {
		IP        string `json:"ip"`
		Timestamp int64  `json:"timestamp"`
	}
	_ = s.db.NewRef("trackings/"+key).
		OrderByChild("timestamp").StartAt(float64(cutoff)).
		Get(ctx, &recent)
	isDup := false
	for _, row := range recent {
		if row.IP == ip {
			isDup = true
			break
		}
	}

	eventID := randID()
	today := time.Now().UTC().Format("2006-01-02")

	_ = s.db.NewRef("trackings/"+key+"/"+eventID).Set(ctx, map[string]interface{}{
		"timestamp":     now,
		"ip":            ip,
		"userAgent":     ua,
		"deviceFp":      shortHash(ua),
		"campaignId":    "global",
		"conversion":    false,
		"earnings":      0,
		"clickId":       clickID,
		"eventId":       eventID,
		"affiliate":     key,
		"affiliateFfId": aff,
		"isDuplicate":   isDup,
		"dateKey":       today,
	})

	_ = s.db.NewRef("clickTracking/"+key+"/summary").Transaction(ctx,
		func(n database.TransactionNode) (interface{}, error) {
			cur := map[string]interface{}{}
			_ = n.Unmarshal(&cur)
			cur["affiliateId"] = key
			cur["totalClicks"] = toInt(cur["totalClicks"]) + 1
			cur["lastClickAt"] = now
			return cur, nil
		})

	_ = s.db.NewRef("clickTracking/"+key+"/clickIds/"+clickID).Transaction(ctx,
		func(n database.TransactionNode) (interface{}, error) {
			cur := map[string]interface{}{}
			_ = n.Unmarshal(&cur)
			cur["affiliateId"] = key
			cur["clickId"] = clickID
			cur["count"] = toInt(cur["count"]) + 1
			cur["lastClickAt"] = now
			return cur, nil
		})

	_ = s.db.NewRef("users/"+key+"/stats").Transaction(ctx,
		func(n database.TransactionNode) (interface{}, error) {
			cur := map[string]interface{}{}
			_ = n.Unmarshal(&cur)
			cur["clicks"] = toInt(cur["clicks"]) + 1
			if isDup {
				cur["duplicateClicks"] = toInt(cur["duplicateClicks"]) + 1
			} else {
				cur["uniqueClicks"] = toInt(cur["uniqueClicks"]) + 1
			}
			return cur, nil
		})

	_ = s.db.NewRef("dailyCounters/"+key+"/"+today).Transaction(ctx,
		func(n database.TransactionNode) (interface{}, error) {
			cur := map[string]interface{}{}
			_ = n.Unmarshal(&cur)
			cur["clicks"] = toInt(cur["clicks"]) + 1
			return cur, nil
		})
}

func incrementLeads(ctx context.Context, db *database.Client, key, today string, amount float64) {
	_ = db.NewRef("users/"+key+"/stats").Transaction(ctx,
		func(n database.TransactionNode) (interface{}, error) {
			cur := map[string]interface{}{}
			_ = n.Unmarshal(&cur)
			cur["leads"] = toInt(cur["leads"]) + 1
			cur["earnings"] = toFloat(cur["earnings"]) + amount
			return cur, nil
		})
	_ = db.NewRef("dailyCounters/"+key+"/"+today).Transaction(ctx,
		func(n database.TransactionNode) (interface{}, error) {
			cur := map[string]interface{}{}
			_ = n.Unmarshal(&cur)
			cur["leads"] = toInt(cur["leads"]) + 1
			cur["earnings"] = toFloat(cur["earnings"]) + amount
			return cur, nil
		})
}

// ────────────────────────────────────────────────────────────────
//  Admin middleware
// ────────────────────────────────────────────────────────────────

func (s *server) requireAdmin(next http.HandlerFunc) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		hdr := r.Header.Get("Authorization")
		if !strings.HasPrefix(hdr, "Bearer ") {
			writeJSON(w, 401, map[string]string{"error": "missing token"})
			return
		}
		tok, err := s.auth.VerifyIDToken(r.Context(), hdr[7:])
		if err != nil {
			writeJSON(w, 401, map[string]string{"error": "invalid token"})
			return
		}

		var isAdmin bool
		_ = s.db.NewRef("admins/" + tok.UID).Get(r.Context(), &isAdmin)
		if !isAdmin {
			email, _ := tok.Claims["email"].(string)
			if email == "" {
				writeJSON(w, 403, map[string]string{"error": "not admin"})
				return
			}
			var mgr struct {
				Active *bool `json:"active"`
			}
			if err := s.db.NewRef("managers/" + safeKey(email)).Get(r.Context(), &mgr); err != nil {
				writeJSON(w, 403, map[string]string{"error": "not admin"})
				return
			}
			if mgr.Active != nil && !*mgr.Active {
				writeJSON(w, 403, map[string]string{"error": "not admin"})
				return
			}
		}
		next(w, r)
	}
}

// ────────────────────────────────────────────────────────────────
//  Utilities
// ────────────────────────────────────────────────────────────────

func clientIP(r *http.Request) string {
	if xff := r.Header.Get("X-Forwarded-For"); xff != "" {
		return strings.TrimSpace(strings.Split(xff, ",")[0])
	}
	host, _, err := net.SplitHostPort(r.RemoteAddr)
	if err != nil {
		return r.RemoteAddr
	}
	return host
}

func safeKey(s string) string {
	repl := strings.NewReplacer(".", "_", "#", "_", "$", "_", "/", "_", "[", "_", "]", "_")
	return repl.Replace(s)
}

func randID() string {
	b := make([]byte, 8)
	_, _ = rand.Read(b)
	return hex.EncodeToString(b)
}

func shortHash(s string) string {
	sum := md5.Sum([]byte(s))
	return hex.EncodeToString(sum[:])[:12]
}

func first(vals ...string) string {
	for _, v := range vals {
		if v != "" {
			return v
		}
	}
	return ""
}

func toInt(v interface{}) int64 {
	switch x := v.(type) {
	case int64:
		return x
	case int:
		return int64(x)
	case float64:
		return int64(x)
	case json.Number:
		n, _ := x.Int64()
		return n
	}
	return 0
}

func toFloat(v interface{}) float64 {
	switch x := v.(type) {
	case float64:
		return x
	case int64:
		return float64(x)
	case int:
		return float64(x)
	case json.Number:
		f, _ := x.Float64()
		return f
	}
	return 0
}

func writeJSON(w http.ResponseWriter, code int, v interface{}) {
	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(code)
	_ = json.NewEncoder(w).Encode(v)
}

func writeText(w http.ResponseWriter, code int, s string) {
	w.Header().Set("Content-Type", "text/plain")
	w.WriteHeader(code)
	io.WriteString(w, s)
}
