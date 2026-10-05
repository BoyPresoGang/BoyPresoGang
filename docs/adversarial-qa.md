# Week 10 Adversarial QA

Assigned member: Abdul Cedick Khalid Kalaw  
Branch: `week10/adversarial-qa`

This document records adversarial checks performed against the running local Laravel application. No production code was modified. Results are limited to behavior directly observed in the browser.

## Environment

- Application URL: `http://127.0.0.1:8000`
- Browser-based manual testing was available.
- No network interception or request throttling tool was available through the QA browser.
- Destructive deletion tests were not performed because existing records were not to be removed without a safe temporary-record cleanup path.

## Executed scenarios

| Scenario | Feature tested | Steps performed | Result | Evidence / observed behavior |
|---|---|---|---|---|
| Very large numeric input | Customer Create | Open `/customers/create`; enter a valid name and a 30-digit contact number; submit. | FAIL | The form remained on the Create Customer page with the entered value and no visible in-page validation or human-readable error. The invalid record was not created. |
| Empty input / missing values | Customer Create | Open `/customers/create`; submit with both required fields empty. | FAIL | The page remained open and no visible in-page validation message appeared in the rendered UI. Native browser validation may have prevented submission, but no useful application feedback was observable. |
| Emoji and unusual Unicode | Customer Create | Enter `<script>alert('x')</script> 🙂` as the name and an invalid 10-digit contact number; submit. | NOT TESTED | No script executed, no alert appeared, and the invalid record was not present in the Customer list afterward. Because the supporting contact value was invalid, successful storage and later HTML escaping of the name were not tested. |
| XSS-style input | Customer Create | Submit the harmless payload `<script>alert('x')</script> 🙂` with invalid supporting data. | NOT TESTED | No alert or script execution was observed. The list did not contain the payload because validation rejected the request. This does not establish a complete stored-XSS test. |
| Back navigation after edit-page load | Customer Edit | Open `/customers/edit/2`, then activate Cancel. | PASS | Navigation changed from `/customers/edit/2` to `/customers`. |
| Nonexistent resource IDs | Customer, Product, Order, Delivery detail | Open each of `/customers/999999`, `/products/999999`, `/orders/999999`, and `/deliveries/999999`. | PASS | Each page displayed a human-readable resource-not-found state and corresponding Back link. |
| Nonexistent application URL | System routing | Open `/not-a-real-route`. | PASS | The application displayed a clear `404 Not Found` page. |
| Double-clicking a submit button | Customer Create | Open `/customers/create` with empty fields and double-click Save Customer. | NOT TESTED | The invalid form did not create a record, but this did not exercise duplicate valid requests. A safe valid double-submit test was not performed because it could create duplicate data. |
| Refresh during/immediately after submission | Create/Edit flows | Attempt to assess refresh timing during a real submission. | NOT TESTED | No safe browser/network control was available to coordinate a refresh during a valid request without risking duplicate or partial data. |
| Act on a deleted record | CRUD actions | Attempt to create and delete a temporary record, then reuse its stale page. | NOT TESTED | This requires a destructive operation and safe cleanup confirmation. Existing records were not deleted. |
| Network disconnected/failed/slow request | All async views | Attempt to simulate network failure or request throttling. | NOT TESTED | The available browser controls did not provide safe request interception, offline mode, or throttling. |
| Over-stock order submission | Order Create | Select `Ring of Regen` with displayed stock `1`, enter quantity `2`, and submit. | FAIL | The form stayed on the page without a visible validation/error message. A backend 422 response was not observed. Reproduction: `/orders/create`, select the product with stock 1, enter quantity 2, submit. |

## Additional observations

- Invalid adversarial Customer submissions did not create visible records named `Huge Input QA` or containing the script payload.
- The Customer, Product, Order, and Delivery detail pages all handled ID `999999` with resource-specific not-found feedback rather than exposing a raw server error.
- No application source, controller, route, model, migration, or existing test file was changed for this QA task.

## Candidate bugs for later triage

### Customer Create validation feedback

Both empty submission and an oversized contact number left the form unchanged without visible in-page validation feedback. The request should be reproduced with browser developer tools or an API trace to distinguish native browser blocking from a missing frontend validation/error-rendering path.

### Order Create over-stock feedback

An order quantity greater than the selected product stock left the form unchanged without visible feedback. The backend rule may still reject the request, but the user-facing Create Order flow did not show a clear error during this check.

These are observations for Week 10 Task 5 triage only. No severity has been assigned and no fixes were made.

## Not tested

- Valid duplicate-submit protection for Create/Edit/Delete actions.
- Refresh during an active valid submission.
- Acting on a genuinely deleted record.
- Offline, failed, and slow network conditions.
- Empty list states for all resources.
- Permission failures for customer, product, order, and delivery destructive actions.
- Full stock mutation and Delivery lifecycle adversarial flows.
