To show how Sentry works in an example web app that uses PHP Laravel

How to integrate the Sentry SDK into Laravel (https://docs.sentry.io/platforms/php/laravel/)
trigger an error that gets sent as Event to Sentry.io Platform
web.php has multiple endpoints for showing different ways that errors are handled


# Setup
1. `composer install`
2. Set your DSN key, projectID, and Sentry OrganizationID in `.env`
4. make
5. `http://localhost:8000/handled` and `http://localhost:8000/unhandled` to trigger errors

# Run With Docker
1. docker build -t my-first-image .
2. docker run -p 8000:8000 my-first-image

# GCP Cloud Run
1. make deploy_gcp
