package main

import (
	"context"
	"fmt"

	firebase "firebase.google.com/go/v4"
	"google.golang.org/api/option"
)

func initFirebase(ctx context.Context, credsPath, dbURL string) (*firebase.App, error) {
	opt := option.WithCredentialsFile(credsPath)
	cfg := &firebase.Config{DatabaseURL: dbURL}

	app, err := firebase.NewApp(ctx, cfg, opt)
	if err != nil {
		return nil, fmt.Errorf("firebase init: %w", err)
	}
	return app, nil
}

func main() {
	app, err := initFirebase(
		context.Background(),
		"path/to/serviceAccountKey.json",
		"https://adbluemedia-156b6-default-rtdb.firebaseio.com",
	)
	if err != nil {
		panic(err)
	}
	fmt.Println("firebase app initialized:", app)
}
