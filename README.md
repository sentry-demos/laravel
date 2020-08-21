# PR Notes
- delete resources/views/home.blade.php and as much front-end View code you can, styling.
- remove additional files

# Sentry Laravel Example

This shows how to use Sentry in Laravel to capture errors/exceptions

# Setup
1. Make sure mysql DB is created (as per .env)
2. `$ compose install`php composer-setup.php

3. Set your DSN key + projectID in `.env`
4. `npm install -g @sentry/cli # remember to specify creds in env vars`
3. Run server. `$ make`
5. `http://localhost:8000/handled` and `http://localhost:8000/unhandled` to trigger errors

# Resources:
- https://sentry.io/for/laravel/
- https://docs.sentry.io/clients/php/
