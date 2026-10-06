# Week 11 Production Deployment

## 1. Deployment Overview

The Water Refilling Station Management System was deployed successfully to Railway for production use during Week 11.

- Hosting platform: Railway
- Repository: `BoyPresoGang/BoyPresoGang`
- Application framework: Laravel 13.26.1
- Application environment: production
- Debug mode: disabled

## 2. Hosting and Runtime

The production application runs on Railway with the following confirmed runtime versions:

- PHP: 8.4.26
- Node.js: 24.21.0

## 3. Environment Configuration

The production deployment uses these confirmed application settings:

```text
APP_ENV=production
APP_DEBUG=false
```

The production `APP_KEY` was generated separately. Its value is intentionally not documented here and must remain private.

## 4. Database and Persistence

The application uses SQLite in production. SQLite persistence is provided by the Railway Volume named `boypresogang-volume`.

- Volume: `boypresogang-volume`
- Volume mount path: `/app/storage/database`
- SQLite database path: `/app/storage/database/database.sqlite`

Database migrations run through the configured application start command during deployment.

## 5. Deployment Process

The production deployment process is:

1. Railway builds and deploys the `BoyPresoGang/BoyPresoGang` repository.
2. The configured PHP and Node.js runtimes are used by the application.
3. The configured application start command runs the database migrations.
4. Laravel starts with `APP_ENV=production` and `APP_DEBUG=false`.
5. The application uses the mounted Railway Volume for the SQLite database.
6. Railway completes the production deployment and exposes the application at its public URL.

The deployment completed successfully on Railway.

## 6. Production Verification

The following production checks were confirmed:

- `/customers` loaded successfully.
- `/api/customers` returned HTTP 200 with an empty `data` array before CRUD testing.
- Customer Create succeeded.
- Customer View succeeded.
- Customer Edit succeeded.
- Customer Delete succeeded.
- An invalid customer API submission returned HTTP 422 with validation feedback.

## 7. Public URL

The deployed production application is available at:

<https://boypresogang-production.up.railway.app>

## 8. Security Notes

- `APP_DEBUG` is disabled in production.
- The production `APP_KEY` is not included in this documentation.
- Production credentials, secrets, and personal login information must not be committed to the repository or included in deployment documentation.
- The SQLite database is stored on the persistent Railway Volume rather than ephemeral application storage.
