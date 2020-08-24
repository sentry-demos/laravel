# Summary

To show how Sentry works in an example web app that uses PHP Laravel

How to integrate the Sentry SDK into Laravel (https://docs.sentry.io/platforms/php/laravel/)
trigger an error that gets sent as Event to Sentry.io Platform
web.php has multiple endpoints for showing different ways that errors are handled


# Setup
1. `$ compose install`php composer-setup.php
2. Set your DSN key + projectID in `.env`
3. `npm install -g @sentry/cli # remember to specify creds in env vars`
4. Run server. `$ make`
5. `http://localhost:8000/handled` and `http://localhost:8000/unhandled` to trigger errors

# Run With Docker
1. docker build -t my-first-image .
2. docker run -p 8001:8001 my-first-image

# GCP Cloud Run
1. make deploy_gcp

# Resources:
- https://sentry.io/for/laravel/
- https://docs.sentry.io/clients/php/
