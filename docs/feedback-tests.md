# Week 8 Feedback Tests

## Scope and execution status

These are manual test cases for the Week 8 feedback states. They are a test plan and reference; they were **not executed as part of this documentation task**. Replace each `Not executed` result with evidence after running the scenario against a configured Laravel application and test database.

## Create tests

### CT-01 — Create success (all resources)

- **Scenario:** Create a valid Customer, Product, Order, and Delivery, one resource at a time.
- **Preconditions/setup:** Application is running; required related records exist for Orders and Deliveries.
- **Steps:** Open each Create page, enter valid data, submit once.
- **Expected result:** The button shows `Saving...` and is disabled during the request. A resource-specific success message appears and the form resets.
- **Result:** Not executed.

### CT-02 — Create validation failure (all resources)

- **Scenario:** Submit invalid required or constrained data: empty customer name, product price `0`, order quantity `0`, or invalid delivery date.
- **Preconditions/setup:** Application is running and each Create page is reachable.
- **Steps:** Enter the invalid value and submit.
- **Expected result:** API `422` is handled without a page crash; a general validation message appears and the returned field message is shown inline. The submit button becomes usable again.
- **Result:** Not executed.

## Update tests

### UT-01 — Update success (all resources)

- **Scenario:** Update an existing Customer, Product, Order, and Delivery with valid values.
- **Preconditions/setup:** Each resource ID exists.
- **Steps:** Open each Edit page, change a valid field, and submit.
- **Expected result:** The button shows `Updating...` and is disabled while pending. A resource-specific success message appears and the updated value persists after refresh.
- **Result:** Not executed.

### UT-02 — Update validation failure (all resources)

- **Scenario:** Submit invalid update data, such as empty customer name, product price `0`, order quantity `0`, or invalid delivery date.
- **Preconditions/setup:** Each resource ID exists.
- **Steps:** Enter invalid data and submit.
- **Expected result:** API `422` is shown inline against the affected field, or in the form-level error when no matching field is available. The button is restored.
- **Result:** Not executed.

## List tests

### LT-01 — List loading

- **Scenario:** Open each resource list page with a delayed API response.
- **Preconditions/setup:** Application is running; throttle the network or delay the list response.
- **Steps:** Navigate to Customers, Products, Orders, and Deliveries.
- **Expected result:** The corresponding Loading state appears while the request is pending, then only the table or another final state remains visible.
- **Result:** Not executed.

### LT-02 — List empty state

- **Scenario:** List API returns HTTP 200 with `data: []`.
- **Preconditions/setup:** Use an empty test dataset or mock the collection response.
- **Steps:** Open each list page.
- **Expected result:** The table is hidden, the resource-specific Empty state is shown, and the Create button remains available.
- **Result:** Not executed.

### LT-03 — List server error and network failure

- **Scenario:** Collection request returns HTTP 500, then simulate a network failure.
- **Preconditions/setup:** Mock or configure the list API to fail.
- **Steps:** Open a list page and click `Try Again` after each failure.
- **Expected result:** The table, Loading state, and Empty state are hidden; a human-readable Error state appears. `Try Again` invokes the same list request again.
- **Result:** Not executed.

## Detail tests

### DT-01 — Detail loading

- **Scenario:** Open each detail route while the detail API would be delayed.
- **Preconditions/setup:** Existing detail ID and a running application.
- **Steps:** Navigate to each detail page.
- **Expected result:** The intended detail Loading state should appear while the request is pending. Current show views contain loading markup but no active detail-fetch script, so this test is currently a planned/gap test.
- **Result:** Not executed — implementation gap documented.

### DT-02 — Detail not found (404)

- **Scenario:** Request a detail ID that does not exist.
- **Preconditions/setup:** Use a non-existent ID and a configured detail API.
- **Steps:** Open the detail route.
- **Expected result:** A clear not-found message is shown without exposing a stack trace. Current show views contain not-found markup, but it is not currently connected to an active detail request.
- **Result:** Not executed — implementation gap documented.

## Delete/cancel tests

### DC-01 — Confirmation and cancellation before request

- **Scenario:** Start a Customer delete, Product delete, Order cancel, and Delivery cancel, then reject confirmation.
- **Preconditions/setup:** Existing row is visible on each list page; monitor network requests.
- **Steps:** Click the row action, choose Cancel in the native confirmation dialog.
- **Expected result:** No DELETE request is sent, no row changes, and no success message is shown.
- **Result:** Not executed.

### DC-02 — Delete/cancel success

- **Scenario:** Complete a permitted Customer delete, Product delete, Order cancel, and Delivery cancel.
- **Preconditions/setup:** Valid authorization is supplied by the test environment; do not hardcode credentials in the UI. Existing target records are available.
- **Steps:** Click Delete/Cancel, confirm, and wait for the response.
- **Expected result:** The row action is disabled and shows deleting/cancelling feedback. A helpful success message appears, then the list refreshes. Delivery remains in the list with status `cancelled` because its endpoint changes status instead of physically deleting the record.
- **Result:** Not executed.

### DC-03 — Delete/cancel forbidden (403)

- **Scenario:** Attempt each delete/cancel without the required authorization.
- **Preconditions/setup:** Use the backend's normal authorization behavior: customer admin role, product manager role, order matching user ID, and delivery dispatcher role are required.
- **Steps:** Confirm the action with missing or unauthorized credentials.
- **Expected result:** A clear permission error is shown, the row remains, and the retry control is available. No authorization rule is bypassed.
- **Result:** Not executed.

### DC-04 — Delete/cancel not found (404)

- **Scenario:** Attempt to delete/cancel an ID that no longer exists.
- **Preconditions/setup:** Make the row stale or call the endpoint with a non-existent ID in a controlled test environment.
- **Steps:** Confirm the action or issue the request through the row flow.
- **Expected result:** A clear not-found message appears, with a retry path where appropriate; the page does not expose a stack trace.
- **Result:** Not executed.

### DC-05 — Delete/cancel server and network failure

- **Scenario:** Delete/cancel returns HTTP 500, then simulate a network failure.
- **Preconditions/setup:** Mock the DELETE response or use a controlled failing test service.
- **Steps:** Confirm the action and observe the feedback; choose the retry control.
- **Expected result:** The action shows in-progress feedback, then a general human-readable error with `Try Delete Again` or `Try Cancel Again`. Retrying sends the same request and does not create duplicate submissions while pending.
- **Result:** Not executed.

## Consistency check

### FB-01 — Consistent feedback behavior

- **Scenario:** Compare all four resources across create, update, list, detail, and delete/cancel states.
- **Preconditions/setup:** Execute or inspect the preceding cases.
- **Steps:** Compare loading labels, success/error message placement, button restoration, retry controls, and confirmation behavior.
- **Expected result:** Equivalent actions use equivalent feedback patterns; resource-specific wording and authorization rules remain clear. Detail loading/not-found/error interactions are identified as gaps until wired.
- **Result:** Not executed.
