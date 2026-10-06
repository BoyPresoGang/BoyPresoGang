# Week 11 — AI Assistance and Prompt Log

AI use was enabled for Week 11. The team used AI assistance to inspect existing implementation, structure focused changes and documentation, and review AI-assisted work before merge. This log is based on the repository history, Week 11 commits/PRs, and the resulting documentation. Exact original prompt text was not preserved for every member, so work summaries are used instead of fabricated quotations.

## 1. Angel Mark S. Cabalgada

### Assigned Week 11 task

Task 1: Squash P0/P1 bugs, specifically Week 10 P1 Issue #180: Order Create did not show useful feedback when the requested quantity exceeded available stock.

### AI-assisted work / prompt summary

AI assistance was used to inspect the Order Create frontend/backend flow, identify why the native HTML `max` constraint prevented the submit handler from running, and plan a focused feedback fix. The exact original prompt text was not preserved.

### What was actually changed or produced

- Removed the dynamic native quantity `max` constraint from `resources/views/orders/create.blade.php`.
- Preserved the backend stock validation and HTTP 422 response.
- Added regression coverage in `tests/Feature/OrderTest.php` for the Order Create stock-feedback behavior.

### Validation/review performed

- Browser validation confirmed that requesting quantity 2 for a product with stock 1 displayed visible quantity and general error feedback.
- The regression test was added, but PHP/Laravel tests were not run because PHP was unavailable at the time.
- The change was reviewed as focused on Issue #180.

### Relevant PR/commit

- PR #187: `fix: show feedback for over-stock orders`
- Commit: `d5c0a90`
- Changed files: `resources/views/orders/create.blade.php`, `tests/Feature/OrderTest.php`

### Limitations

PHP/Laravel automated test execution was unavailable. No passing PHP test result is claimed.

## 2. Abdul Cedick K. Kalaw

### Assigned Week 11 task

Task 2: Pay down technical debt.

### AI-assisted work / prompt summary

AI assistance was used to inspect repeated Customer and Product validation code and structure a small shared validation refactor. The exact original prompt text was not preserved.

### What was actually changed or produced

The focused refactor:

- Added `Controller::validateRequest()` to centralize the existing validator creation and standardized 422 response format.
- Updated `CustomerController` to use the shared helper.
- Updated `ProductController` to use the shared helper.
- Preserved the existing Customer and Product validation rules and response structure.

### Validation/review performed

The commit diff was reviewed for the limited three-file scope and for preservation of the existing validation behavior. No additional refactoring or test result is claimed beyond the repository evidence.

### Relevant PR/commit

- PR #190: `refactor: centralize customer and product validation`
- Commit: `751da8f`
- Changed files: `app/Http/Controllers/Controller.php`, `app/Http/Controllers/CustomerController.php`, `app/Http/Controllers/ProductController.php`

### Limitations

The repository history does not preserve an exact prompt or a verified automated test run for this task.

## 3. Christian Jay Lord Alsa Pedere

### Assigned Week 11 task

Task 3: Set up environments and configuration.

### AI-assisted work / prompt summary

AI was used to guide the inspection and validation steps for production-safe environment configuration. The exact original prompt text was not preserved.

### What was actually changed or produced

- Confirmed `.env` is not tracked by Git.
- Confirmed `.env.example` is tracked and uses safe placeholders.
- Confirmed Laravel uses the existing environment/configuration mechanism.
- Changed `.env.example` so `APP_DEBUG=false` is documented for production-safe configuration.

### Validation/review performed

- Verified `.env` was untracked.
- Reviewed `.env.example` for real credentials and found only empty/null placeholders.
- Reviewed configuration files for environment-variable usage.
- Reviewed the focused diff.

### Relevant PR/commit

- PR #191: `chore: prepare environment configuration`
- Commit: `778a5d6`
- Changed files: `.env.example`, `docs/ai-notes/week-11.md`

### Limitations

No real secret values are included. The repository history records inspection and manual review, but does not preserve an exact AI prompt or a separate automated test result.

## 4. Rommel John M. Agolito

### Assigned Week 11 task

Task 4: Deploy the Water Refilling Station Management System to a live host.

### AI-assisted work / prompt summary

AI assistance was used to help inspect, structure, and document the Railway deployment configuration and production verification process. The exact original prompt text was not preserved.

### What was actually changed or produced

- Deployed the application to Railway.
- Configured PHP 8.4, required build/deploy packages, production environment variables, a separately generated production `APP_KEY`, SQLite persistence through a Railway Volume, migrations, and the Laravel production start command.
- Documented the deployment in `docs/deployment.md`.
- Production URL: <https://boypresogang-production.up.railway.app>
- Recorded verification of `/customers`, `/api/customers`, customer CRUD, and an invalid customer API request returning HTTP 422.

The actual `APP_KEY` value and other secret values are not included in this log.

### Validation/review performed

The Railway deployment completed successfully. The documented production checks included:

- `/customers` loaded successfully.
- `/api/customers` returned HTTP 200 with an empty data array before CRUD testing.
- Customer Create, View, Edit, and Delete succeeded.
- An invalid customer API submission returned HTTP 422 with validation feedback.

### Relevant PR/commit

- PR #188: `docs: document Week 11 deployment`
- Commit: `eda9978`
- Changed file: `docs/deployment.md`

### Limitations

The deployment work is distinct from Jerfrans’s formal Week 11 Task 5 smoke test. No secret values are documented.

## 5. Jerfrans D. Guerbo

### Assigned Week 11 task

Task 5: Smoke-test the live application.

### AI-assisted work / prompt summary

AI assistance was used to organize and record the formal live smoke-test results in the deployment documentation. The exact original prompt text was not preserved.

### What was actually changed or produced

- Added the Week 11 Task 5 smoke-test section to `docs/deployment.md`.
- Tested the live Customer workflow at <https://boypresogang-production.up.railway.app/customers>.
- Verified Customer Create, View, Edit, Delete, and confirmation that the deleted customer no longer appeared in the list.
- Verified client-side validation for a one-character name and invalid contact format.
- Verified backend validation with `POST /api/customers` using invalid data.

The recorded backend response was:

```json
{"status":422,"error":"The name field is required.","field":"name"}
```

### Validation/review performed

The formal Week 11 Task 5 smoke test was performed by Jerfrans D. Guerbo. The results were recorded as PASS only for the listed checks. No additional tests are claimed.

### Relevant PR/commit

- PR #189: `docs: record Week 11 live smoke test`
- Commit: `0385584`
- Changed file: `docs/deployment.md`

### Limitations

This smoke-test work is distinct from Rommel’s earlier deployment verification. No secrets or unverified test results are included.

## Final note

This log is based on the actual Week 11 repository work, commits, pull requests, and existing documentation. No secrets, production `APP_KEY` values, credentials, or fabricated prompt quotations are included.
