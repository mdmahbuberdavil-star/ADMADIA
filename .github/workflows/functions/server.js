import express from 'express';
import admin from 'firebase-admin';
import crypto from 'crypto';

if (!process.env.FIREBASE_SERVICE_ACCOUNT) {
    console.error('FATAL: FIREBASE_SERVICE_ACCOUNT env var is not set.');
    process.exit(1);
}

admin.initializeApp({
    credential: admin.credential.cert(JSON.parse(process.env.FIREBASE_SERVICE_ACCOUNT)),
    databaseURL: 'https://adbluemedia-156b6-default-rtdb.firebaseio.com'
});

const db   = admin.database();
const auth = admin.auth();
const app  = express();
app.set('trust proxy', true);
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const DEDUP_WINDOW_MS = 24 * 60 * 60 * 1000;
const todayKey = () => new Date().toISOString().slice(0, 10);
const randId   = () => crypto.randomBytes(8).toString('hex');
const safeKey  = s => String(s).replace(/[\.#\$\/\[\]]/g, '_');

app.get('/', (_req, res) => res.status(200).send('AdMadia tracker OK'));

// ────────────────────────────────────────────────────────────────
//  GET /go/:clickId?aff=FF-…&dest=<urlencoded offer url>
//  Records click, then 302-redirects to offer with sub6 & aff_id.
// ────────────────────────────────────────────────────────────────
app.get('/go/:clickId', async (req, res) => {
    const { clickId } = req.params;
    const { aff, dest } = req.query;
    if (!dest) return res.status(400).send('missing dest');

    const destination = decodeURIComponent(dest);
    const ip  = (req.headers['x-forwarded-for'] || req.ip || 'unknown')
                 .toString().split(',')[0].trim();
    const ua  = String(req.headers['user-agent'] || '').slice(0, 250);
    const now = Date.now();

    let affiliateKey = null;
    try {
        const idx = await db.ref(`clickIdIndex/${clickId}`).once('value');
        if (idx.exists()) {
            affiliateKey = idx.val().affiliateKey;
        } else if (aff) {
            const snap = await db.ref('users')
                .orderByChild('profile/ffid').equalTo(aff).once('value');
            snap.forEach(c => { affiliateKey = c.key; return true; });
        }
    } catch (e) { console.error('affiliate lookup failed', e); }

    if (affiliateKey) {
        try {
            const recent = await db.ref(`trackings/${affiliateKey}`)
                .orderByChild('timestamp').startAt(now - DEDUP_WINDOW_MS)
                .once('value');
            let isDuplicate = false;
            recent.forEach(c => {
                const t = c.val();
                if (t && t.ip === ip) { isDuplicate = true; return true; }
            });

            const eventId = randId();
            await db.ref(`trackings/${affiliateKey}/${eventId}`).set({
                timestamp: now, ip, userAgent: ua,
                deviceFp: crypto.createHash('md5').update(ua).digest('hex').slice(0, 12),
                campaignId: 'global', conversion: false, earnings: 0,
                clickId, eventId, affiliate: affiliateKey,
                affiliateFfId: aff || null, isDuplicate, dateKey: todayKey()
            });

            await db.ref(`clickTracking/${affiliateKey}/summary`).transaction(s => {
                s = s || { totalClicks: 0 };
                s.affiliateId = affiliateKey;
                s.totalClicks = (s.totalClicks || 0) + 1;
                s.lastClickAt = now;
                return s;
            });
            await db.ref(`clickTracking/${affiliateKey}/clickIds/${clickId}`).transaction(s => {
                s = s || { count: 0 };
                s.affiliateId = affiliateKey;
                s.clickId = clickId;
                s.count = (s.count || 0) + 1;
                s.lastClickAt = now;
                return s;
            });
            await db.ref(`users/${affiliateKey}/stats`).transaction(s => {
                s = s || { clicks: 0, uniqueClicks: 0, duplicateClicks: 0, leads: 0, earnings: 0 };
                s.clicks = (s.clicks || 0) + 1;
                if (isDuplicate) s.duplicateClicks = (s.duplicateClicks || 0) + 1;
                else             s.uniqueClicks    = (s.uniqueClicks    || 0) + 1;
                return s;
            });
            await db.ref(`dailyCounters/${affiliateKey}/${todayKey()}`).transaction(s => {
                s = s || { clicks: 0, leads: 0, earnings: 0 };
                s.clicks = (s.clicks || 0) + 1;
                return s;
            });
        } catch (e) { console.error('click recording failed', e); }
    }

    const u = new URL(destination);
    u.searchParams.set('sub6', clickId);
    if (aff) u.searchParams.set('aff_id', aff);
    res.redirect(302, u.toString());
});

// ────────────────────────────────────────────────────────────────
//  /postback?click_id=…&payout=…&status=1&lead_id=…
// ────────────────────────────────────────────────────────────────
app.all('/postback', async (req, res) => {
    const q = { ...req.query, ...req.body };
    const { click_id, payout, status, lead_id } = q;
    if (!click_id) return res.status(400).send('missing click_id');

    const amount       = Number(payout || 0);
    const isConversion = String(status ?? '1') === '1' ||
                         String(status).toLowerCase() === 'approved';

    try {
        const idx = await db.ref(`clickIdIndex/${click_id}`).once('value');
        if (!idx.exists()) return res.status(200).send('unknown click_id');
        const affiliateKey = idx.val().affiliateKey;

        const latest = await db.ref(`trackings/${affiliateKey}`)
            .orderByChild('clickId').equalTo(click_id)
            .limitToLast(1).once('value');

        let eventId = null, event = null;
        latest.forEach(c => { eventId = c.key; event = c.val(); });

        if (eventId && event && !event.conversion && isConversion) {
            await db.ref(`trackings/${affiliateKey}/${eventId}`).update({
                conversion: true, earnings: amount,
                leadId: lead_id || null, convertedAt: Date.now()
            });
            await db.ref(`users/${affiliateKey}/stats`).transaction(s => {
                s = s || { clicks: 0, leads: 0, earnings: 0 };
                s.leads    = (s.leads    || 0) + 1;
                s.earnings = (s.earnings || 0) + amount;
                return s;
            });
            await db.ref(`dailyCounters/${affiliateKey}/${todayKey()}`).transaction(s => {
                s = s || { clicks: 0, leads: 0, earnings: 0 };
                s.leads    = (s.leads    || 0) + 1;
                s.earnings = (s.earnings || 0) + amount;
                return s;
            });
        }
    } catch (e) { console.error('postback failed', e); }
    res.status(200).send('ok');
});

// ────────────────────────────────────────────────────────────────
//  Admin-only endpoints (Firebase ID token required)
// ────────────────────────────────────────────────────────────────
async function requireAdmin(req, res, next) {
    const hdr = req.headers.authorization || '';
    const token = hdr.startsWith('Bearer ') ? hdr.slice(7) : null;
    if (!token) return res.status(401).json({ error: 'missing token' });
    try {
        const decoded = await auth.verifyIdToken(token);
        const adminSnap = await db.ref(`admins/${decoded.uid}`).once('value');
        if (adminSnap.exists() && adminSnap.val() === true) {
            req.adminUid = decoded.uid;
            return next();
        }
        const email = decoded.email || '';
        const mgrSnap = await db.ref(`managers/${safeKey(email)}`).once('value');
        if (mgrSnap.exists() && mgrSnap.val().active !== false) {
            req.adminUid = decoded.uid;
            return next();
        }
        return res.status(403).json({ error: 'not admin' });
    } catch (e) {
        return res.status(401).json({ error: e.message });
    }
}

app.post('/admin/approve-lead', requireAdmin, async (req, res) => {
    const { evId, affKey, amount } = req.body;
    if (!evId || !affKey) return res.status(400).json({ error: 'evId and affKey required' });
    const payout = Number(amount || 25);
    const day = todayKey();
    try {
        await db.ref(`trackings/${affKey}/${evId}`).update({
            conversion: true, earnings: payout, convertedAt: Date.now()
        });
        await db.ref(`users/${affKey}/stats`).transaction(s => {
            s = s || { clicks: 0, leads: 0, earnings: 0 };
            s.leads    = (s.leads    || 0) + 1;
            s.earnings = (s.earnings || 0) + payout;
            return s;
        });
        await db.ref(`dailyCounters/${affKey}/${day}`).transaction(s => {
            s = s || { clicks: 0, leads: 0, earnings: 0 };
            s.leads    = (s.leads    || 0) + 1;
            s.earnings = (s.earnings || 0) + payout;
            return s;
        });
        await db.ref(`leads/${Date.now()}`).set({
            clickId: evId, affiliate: affKey, earnings: payout, timestamp: Date.now()
        });
        res.json({ ok: true });
    } catch (e) { res.status(500).json({ error: e.message }); }
});

app.post('/admin/manual-update', requireAdmin, async (req, res) => {
    const { target, amount, action } = req.body;
    if (!target || isNaN(Number(amount))) return res.status(400).json({ error: 'bad input' });
    const key = safeKey(target);
    const amt = Number(amount);
    try {
        await db.ref(`users/${key}/stats`).transaction(s => {
            s = s || { clicks: 0, leads: 0, earnings: 0 };
            if (action === 'add_balance') s.earnings = (s.earnings || 0) + amt;
            else if (action === 'add_lead') {
                s.leads    = (s.leads    || 0) + amt;
                s.earnings = (s.earnings || 0) + amt * 25;
            }
            return s;
        });
        res.json({ ok: true });
    } catch (e) { res.status(500).json({ error: e.message }); }
});

const PORT = process.env.PORT || 8080;
app.listen(PORT, () => console.log(`AdMadia tracker listening on :${PORT}`));
