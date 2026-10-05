# Week 9 AI Notes

## Assignment

Week 9 focuses on reviewing AI-assisted code, documenting AI prompts, performing human review, identifying edge cases, and ensuring changes pass the required review process.

---

## Member 1 — Mark

**Assigned member:** Angel Mark S. Cabalgada  
**Task:** Order API Validation Improvement  
**Deliverable:** Improve validation for Order customer references without changing existing product handling or Order business logic.

### AI assistance

AI was used to inspect the repository for small API validation/error-handling opportunities and identify a suitable Week 9 improvement.

### Prompt used

> We are completing Week 9 Task 1 for our Water Refilling Station Management System.
>
> You are assisting Member 1 (Mark) with an AI-assisted API validation/error-handling improvement.
>
> First, INSPECT the current repository and identify 2–3 small, real opportunities for improving API validation or error handling.
>
> Focus specifically on:
> - Missing or weak request validation
> - Incorrect or inconsistent HTTP status codes
> - Missing 404 handling
> - Missing 422 validation responses
> - Missing 500/error handling
> - Edge cases that could cause misleading or unhelpful API responses
> - Consistency with the existing Laravel API patterns
>
> Do NOT modify any files yet.
>
> Recommend the single best candidate for a small Week 9 Task 1 PR.

AI identified a missing existence validation for `Order.customer_id`.

### AI changes reviewed

The AI changed only:

`app/Http/Controllers/OrderController.php`

The validation was changed from:

```php
'customer_id' => "{$required}|integer",
```

to:

```php
'customer_id' => "{$required}|integer|exists:customers,id",
```

Existing `product_id` validation and product-unavailable behavior were intentionally preserved.

The change applies to both Order creation and update because both use the shared `rules()` method.

### AI self-review

AI reviewed:

- Correct validation behavior.
- Valid customer IDs continuing to work.
- Nonexistent customer IDs returning the existing 422 response.
- Preservation of product handling.
- Preservation of Order business logic and authorization.
- Scope of the change.

No blocking issue was found.

### Tests and checks

- `git diff --check` — passed.
- `php artisan test --filter=OrderTest` — attempted but could not run because PHP was unavailable in the environment.
- No automated test result is claimed as passing.

---

## Member 2 — Rommel

**Assigned member:** Rommel John M. Agolito  
**Task:** Delivery Cancellation Feedback Improvement  
**Deliverable:** Improve Delivery cancellation feedback when cancellation succeeds but the subsequent list refresh fails.

### AI assistance

AI was used to inspect the existing Delivery List implementation and identify a small UI/error-state improvement.

### Prompt used

> We are completing Week 9 Task 1 for our Water Refilling Station Management System.
>
> Inspect the existing Delivery List and identify a small UI/UX or error-state improvement.
>
> Focus on a real existing issue and keep the change frontend-only and narrowly scoped.
>
> Preserve existing authorization, cancellation behavior, confirmation, error handling, API behavior, and business logic.
>
> Do not modify backend code, database/schema, Order → Delivery behavior, or unrelated files.

AI identified that a successful Delivery cancellation could be followed by a failed list refresh, causing the UI to misleadingly report the cancellation itself as a network failure.

### AI changes reviewed

The AI changed only:

`resources/views/deliveries/index.blade.php`

The improvement:

- Separates successful cancellation from subsequent list-refresh failure.
- Displays `Delivery cancelled, but the list could not be refreshed.` when cancellation succeeds but refreshing the list fails.
- Provides a `Try Refresh Again` action for the refresh failure.
- Prevents overlapping refresh retries.
- Clears stale refresh-failure feedback after a successful retry.
- Preserves existing 403/404/422/500/network handling.
- Preserves confirmation, loading, disabled-button behavior, and authorization.

### AI self-review

AI reviewed:

- Successful cancellation behavior.
- DELETE error handling.
- Refresh failure handling.
- Retry behavior.
- Loading/disabled states.
- Potential concurrent refresh retries.
- Stale feedback after a successful retry.
- Scope of the change.

The two concrete issues found during review were addressed before commit.

### Tests and checks

- `git diff --check` — passed.
- JavaScript syntax check — passed.
- No live browser/API integration test was executed for this change.

---

## Member 3 — Jerfrans

**Assigned member:** Jerfrans D. Guerbo  
**Task:** Order Validation Test Coverage  
**Deliverable:** Add focused automated test coverage for Orders using a nonexistent `customer_id`.

### AI assistance

AI was used to inspect the repository for small testing/documentation improvement opportunities.

### Prompt used

> We are completing Week 9 Task 1 for our Water Refilling Station Management System.
>
> Inspect the current repository and identify 2–3 small, real opportunities related to:
>
> - Missing or weak automated tests
> - Tests that do not cover an important edge case
> - Inconsistent test coverage
> - Missing or unclear developer documentation
>
> Recommend the single best candidate for a small Week 9 Task 1 PR.
>
> Do not modify any files yet.

AI identified missing coverage for a supplied but nonexistent Order `customer_id`.

### AI changes reviewed

The AI modified only:

`tests/Feature/OrderTest.php`

The test:

- Creates a valid Product fixture.
- Determines a nonexistent customer ID using:

```php
$nonexistentCustomerId = (int) (Customer::max('id') ?? 0) + 1;
```

- Submits an Order using that nonexistent customer ID.
- Asserts HTTP 422.
- Asserts `status: 422`.
- Asserts `field: customer_id`.

The deterministic ID approach was added after AI self-review identified that a hard-coded `999999` could theoretically collide with future fixtures.

### AI self-review

AI confirmed:

- The derived customer ID is greater than the current maximum Customer ID.
- The test is isolated using `RefreshDatabase`.
- The Product fixture prevents unrelated product validation from interfering.
- The test follows the existing Arrange/Act/Assert style.
- No application logic was changed.

### Tests and checks

- `git diff --check` — passed.
- `php artisan test --filter=OrderTest` — attempted but could not run because PHP was unavailable in the environment.
- No automated test result is claimed as passing.

---

## Member 4 — Abdul

**Assigned member:** Abdul Cedick Khalid Kalaw  
**Task:** Product List UI Feedback-State Improvement  
**Deliverable:** Improve the existing Product List loading and error feedback states without changing backend behavior, API contracts, CRUD behavior, authorization, stock rules, or routes.

### AI assistance

AI was used to review the existing Product List in `resources/views/products/index.blade.php` and make one small, focused UI feedback-state improvement.

### Prompt used

> Review the existing Product List in `resources/views/products/index.blade.php`. Make one small, focused UI feedback-state improvement for Week 9. Improve the clarity and user feedback of the existing loading and error states, including making the retry action clearer. Preserve the existing layout, Product API endpoint, API response structure, CRUD behavior, delete handling, authorization, stock rules, routes, and all existing functionality. Do not redesign the page, add dependencies, or modify backend code. Do not remove existing error handling. Only modify what is necessary for the feedback-state improvement.

### AI changes reviewed

The AI modified only:

`resources/views/products/index.blade.php`

Changes:

- Added `role="status"`, `aria-live="polite"`, and `aria-busy="true"` to the loading state.
- Added `role="alert"` and `aria-live="assertive"` to the error state.
- Changed retry button text from `Try Again` to `Retry loading products`.

No backend files, API endpoints, routes, CRUD behavior, delete handling, authorization, or stock rules were changed.

### Human review

The Product List was manually tested in the browser.

Verified:

- Normal Product List loading.
- Product List error state.
- Retry action.
- Successful restoration of the Product List after retry.

### Tests and checks

- `git diff --check` — passed.
- Product List normal loading — verified.
- Product List error state — verified.
- Product List retry action — verified.
- `php artisan test tests/Feature/ProductTest.php` — 3 tests passed, 8 assertions.

---

## Member 5 — Christian

**Assigned member:** Christian Jay Lord Alsa Pedere  
**Task:** Customer List UI Feedback-State Improvement  
**Deliverable:** Improve the existing Customer List feedback states without changing backend behavior, API contracts, CRUD behavior, authorization, routes, or other existing functionality.

### AI assistance

AI was used to review the existing Customer List in `resources/views/customers/index.blade.php` and make one small, focused UI feedback-state improvement.

### Prompt used

> Review the existing Customer List in `resources/views/customers/index.blade.php` for the Week 9 task: **Customer List UI Feedback-State Improvement**.
>
> Make one small, focused frontend UI improvement to the existing feedback states. Improve the clarity and user feedback of the existing loading, empty, error, and retry/feedback presentation where appropriate, without redesigning the Customer List.
>
> Preserve the existing Customer List layout and styling.
> Preserve the existing Customer API endpoint: `/api/customers`.
> Preserve the existing API response structure.
> Preserve all existing CRUD behavior.
> Preserve existing delete handling and authorization.
> Preserve existing routes.
> Do not modify backend code.
> Do not change validation, business rules, or unrelated functionality.
> Do not add dependencies.
> Do not remove or bypass existing error handling.
> Do not modify files unrelated to this assigned Customer List UI feedback-state improvement.
> Keep the change small and focused.
> Do not claim tests were run unless they are actually run.

### AI changes reviewed

The AI modified only:

`resources/views/customers/index.blade.php`

Changes:

- Added `role="status"` and `aria-live="polite"` to the existing action feedback state.
- Added `role="status"`, `aria-live="polite"`, and `aria-busy="true"` to the existing loading state.
- Added `role="status"` and `aria-live="polite"` to the existing empty state.
- Added `role="alert"` to the existing error state.

The existing layout and styling were preserved.

No backend files, API endpoints, CRUD behavior, delete handling, authorization, routes, or business rules were changed.

### Human review

The existing Customer List implementation was inspected before editing.

The Git diff was reviewed to verify that the change was limited to the intended feedback-state improvement.

`git diff --check` was run and passed with no output.

### Tests and checks

- `git diff --check` — passed with no output.
- `php artisan test tests/Feature/CustomerTest.php` — 2 tests passed and 1 test failed.
- The failing happy-path test expects HTTP 201 but received 422 because the test uses a 10-digit `contact_number`, while the existing CustomerController validation requires exactly 11 digits.
- No backend changes were made because the Week 9 task is limited to the Customer List UI feedback-state improvement.
- No test result is claimed as fully passing.

---

## Week 9 Review Status

Each member's Week 9 Task 1 work is intended to go through a reviewed pull request before merging.

- Mark — Order API validation improvement — PR #169 — merged after review.
- Rommel — Delivery cancellation feedback improvement — PR #167 — merged after review.
- Jerfrans — Order validation test coverage — PR #170 — merged after review.
- Abdul — Product List feedback-state improvement — completed and merged.
- Christian — Customer List feedback-state improvement — PR #171 — merged after review.