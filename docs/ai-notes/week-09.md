# Week 9 AI Notes

## Assignment

* **Assigned member:** Christian Jay Lord Alsa Pedere
* **Task:** Customer List UI Feedback-State Improvement
* **Deliverable:** Improve the existing Customer List feedback states without changing backend behavior, API contracts, CRUD behavior, authorization, routes, or other existing functionality.

## AI assistance

AI was used to review the existing Customer List in `resources/views/customers/index.blade.php` and make one small, focused UI feedback-state improvement for Week 9.

### Prompt used

> Review the existing Customer List in `resources/views/customers/index.blade.php` for the Week 9 task: **Customer List UI Feedback-State Improvement**.
>
> Make one small, focused frontend UI improvement to the existing feedback states. Improve the clarity and user feedback of the existing **loading, empty, error, and retry/feedback presentation** where appropriate, without redesigning the Customer List.
>
> STRICT REQUIREMENTS:
>
> * Preserve the existing Customer List layout and styling.
> * Preserve the existing Customer API endpoint: `/api/customers`.
> * Preserve the existing API response structure.
> * Preserve all existing CRUD behavior.
> * Preserve existing delete handling and authorization.
> * Preserve existing routes.
> * Do not modify backend code.
> * Do not change validation, business rules, or unrelated functionality.
> * Do not add dependencies.
> * Do not remove or bypass existing error handling.
> * Do not modify files unrelated to this assigned Customer List UI feedback-state improvement.
> * Keep the change small and focused.
> * Do not claim tests were run unless they are actually run.
>
> Before editing, inspect the existing implementation and make only the minimum changes necessary for the feedback-state improvement.
>
> After editing, report:
>
> 1. Exactly what you changed.
> 2. Exactly which files were modified.
> 3. What existing functionality was intentionally preserved.
> 4. Any tests or checks actually performed, without inventing results.

### AI changes reviewed

The AI modified only `resources/views/customers/index.blade.php`.

The reviewed changes were:

* Added `role="status"` and `aria-live="polite"` to the existing action feedback state.
* Added `role="status"`, `aria-live="polite"`, and `aria-busy="true"` to the existing loading state.
* Added `role="status"` and `aria-live="polite"` to the existing empty state.
* Added `role="alert"` to the existing error state.

The existing layout and styling were preserved.

No backend files, API endpoints, CRUD behavior, delete handling, authorization, routes, or business rules were changed.

## Human review

The existing Customer List implementation was inspected before editing.

The Git diff was reviewed to verify that the change was limited to the intended feedback-state improvement.

`git diff --check` was run and passed with no output.

The AI reported that tests were not run. No test results are claimed here.

## Tests and checks

* `git diff --check` â€” passed with no output.
* `php artisan test tests/Feature/CustomerTest.php` — 2 tests passed, 1 test failed. The failing happy-path test expects HTTP 201 but received 422 because the test uses a 10-digit `contact_number`, while the existing CustomerController validation requires exactly 11 digits. No backend changes were made because the Week 9 task is limited to the Customer List UI feedback-state improvement.
