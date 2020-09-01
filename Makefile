# Must have `sentry-cli` installed globally
# Following variable must be passed in
#  SENTRY_AUTH_TOKEN

SENTRY_ORG=testorg-az
SENTRY_PROJECT=laraveladam
VERSION=`sentry-cli releases propose-version`
COMMIT_SHA=$(shell git rev-parse HEAD)
WHOAMI=$(shell whoami)
GCP_SERVICE_NAME=laravel-errors
GCP_WORKSPACE_NAME=workspace_laravels_errors
REPOSITORY=us.gcr.io/sales-engineering-sf

setup_release: create_release associate_commits serve

create_release:
	sentry-cli releases -o $(SENTRY_ORG) new -p $(SENTRY_PROJECT) $(VERSION)

associate_commits:
	$(SENTRY_CLI) releases -o $(SENTRY_ORG) -p $(SENTRY_PROJECT) set-commits --local $(VERSION)

serve:
	php artisan cache:clear && php artisan serve

# GCP
deploy_gcp: build_image deploy_service

build_image:
	gcloud builds submit --substitutions=COMMIT_SHA=$(COMMIT_SHA) --config=cloudbuild.yaml

deploy_service:
	gcloud run deploy $(WHOAMI)-$(GCP_SERVICE_NAME) --image $(REPOSITORY)/$(GCP_WORKSPACE_NAME):$(COMMIT_SHA) --platform managed

.PHONY: setup_release create_release associate_commits serve deploy_gcp
