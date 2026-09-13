// Realtime Database client — from the same app:
dbClient, err := app.Database(ctx)   // *database.Client

// Verify client ID tokens for the /admin/* endpoints:
authClient, err := app.Auth(ctx)
tok, err := authClient.VerifyIDToken(ctx, bearerToken)
// tok.UID, tok.Claims["email"]

// Atomic increments on RTDB (Go equivalent of admin.database().ref(...).transaction()):
ref := dbClient.NewRef("users/" + key + "/stats/clicks")
err = ref.Transaction(ctx, func(node database.TransactionNode) (interface{}, error) {
    var cur int64
    _ = node.Unmarshal(&cur)          // ignore type error on first write
    return cur + 1, nil
})
