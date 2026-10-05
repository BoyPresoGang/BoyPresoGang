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

### DT-01 — Detail loading state

- **Scenario:** Open each detail route while its `/api/{resource}/{id}` response is delayed.
- **Preconditions/setup:** Existing detail ID, running application, and delayed detail response.
- **Steps:** Navigate to Customer, Product, Order, and Delivery detail pages.
- **Expected result:** The corresponding Loading state is visible while the request is pending, then only the final state remains visible.
- **Result:** Not executed.

### DT-02 — Detail success and rendering

- **Scenario:** Load an existing Customer, Product, Order, and Delivery detail record.
- **Preconditions/setup:** Existing IDs and successful API responses with `status: 200` and `data`.
- **Steps:** Open each detail page.
- **Expected result:** API data is displayed in the success view without exposing raw response data. The Edit link uses the current record ID.
- **Result:** Not executed.

### DT-03 — Detail not found (404)

- **Scenario:** Request a detail ID that does not exist.
- **Preconditions/setup:** Use a non-existent ID and a configured detail API.
- **Steps:** Open the detail route.
- **Expected result:** A clear not-found message is shown without exposing a stack trace, and Back returns to the resource list.
- **Result:** Not executed.

### DT-04 — Detail invalid or non-200 response

- **Scenario:** Detail API returns malformed JSON, missing `data`, or a non-200 status other than the normal successful response.
- **Preconditions/setup:** Mock or configure the detail endpoint to return the invalid response.
- **Steps:** Open the detail route.
- **Expected result:** The page shows its human-readable not-found or error state and does not render fabricated record values.
- **Result:** Not executed.

### DT-05 — Detail network failure

- **Scenario:** Detail API request fails at the network level.
- **Preconditions/setup:** Application is running; block or interrupt the detail request.
- **Steps:** Open the detail route.
- **Expected result:** The human-readable detail error state appears without a stack trace.
- **Result:** Not executed.

### DT-06 — Detail retry

- **Scenario:** Detail request fails, then the user selects `Try Again`.
- **Preconditions/setup:** First request fails and a subsequent request is available to succeed.
- **Steps:** Open the detail page, observe the error state, and click `Try Again`.
- **Expected result:** The same detail fetch is attempted again and the page can transition to the success state if the retry succeeds.
- **Result:** Not executed.

### DT-07 — Detail navigation

- **Scenario:** Use Edit and Back navigation from each successful detail page.
- **Preconditions/setup:** Existing detail record loaded successfully.
- **Steps:** Click Edit, then separately return to the detail page and click Back.
- **Expected result:** Edit navigates to `/resource/edit/{current-id}` and Back navigates to the corresponding resource list.
- **Result:** Not executed.

## Relationship-loading tests

### RT-01 — Order Create customer and product loading

- **Scenario:** Load customer and product options on Order Create.
- **Preconditions/setup:** Application is running; `/api/customers` and `/api/products` return valid data.
- **Steps:** Open Order Create and observe both selects while requests are pending and after they complete.
- **Expected result:** Customer data comes from `/api/customers`, product data comes from `/api/products`, loading placeholders are shown while pending, and only current API records become selectable. No visible retry button is shown.
- **Result:** Not executed.

### RT-02 — Order Create empty and failure states

- **Scenario:** Customer/product APIs return empty arrays, then fail with server or network errors.
- **Preconditions/setup:** Mock each endpoint independently.
- **Steps:** Open Order Create under each response condition.
- **Expected result:** Empty results show `No customers available` or `No products available`. Failures show human-readable affected-dropdown errors without raw JSON or status text. Refreshing the page starts loading again.
- **Result:** Not executed.

### RT-03 — Order submission uses selected current IDs

- **Scenario:** Submit an order using dynamically loaded customer and product records.
- **Preconditions/setup:** Customer and product APIs return records with known IDs; order POST endpoint accepts the request.
- **Steps:** Select current customer/product options, enter a valid quantity, and submit.
- **Expected result:** `POST /api/orders` receives the selected values as `customer_id` and `product_id`; the existing success and validation feedback remains unchanged.
- **Result:** Not executed.

### RT-04 — Delivery Create customer loading, empty, and failure states

- **Scenario:** Load customer options on Delivery Create under success, empty, server-error, and network-failure responses.
- **Preconditions/setup:** Mock `/api/customers` as needed.
- **Steps:** Open Delivery Create under each response condition.
- **Expected result:** Loading shows `Loading customers...`; valid current customers become selectable; empty data shows `No customers available`; failures show a human-readable error and no visible retry button.
- **Result:** Not executed.

### RT-05 — Delivery Create submission uses selected customer ID

- **Scenario:** Create a delivery using a dynamically loaded customer.
- **Preconditions/setup:** Customer API returns a known customer; delivery POST endpoint is available.
- **Steps:** Select the current customer, enter a valid date and status, and submit.
- **Expected result:** `POST /api/deliveries` receives the selected `customer_id`; existing delivery success and validation feedback remains unchanged.
- **Result:** Not executed.

### RT-06 — Delivery Edit customer loading and selection

- **Scenario:** Load an existing delivery and its customer options.
- **Preconditions/setup:** Delivery API returns an existing `customer_id`; customer API returns that customer.
- **Steps:** Open Delivery Edit and observe the customer select before and after both requests complete.
- **Expected result:** Customer loading is shown first, current customer options are populated, and the existing delivery customer is automatically selected after customer data loads.
- **Result:** Not executed.

### RT-07 — Delivery Edit empty and failure states

- **Scenario:** Customer API returns an empty array, server error, or network failure while editing a delivery.
- **Preconditions/setup:** Existing delivery record and controlled customer API responses.
- **Steps:** Open Delivery Edit under each response condition.
- **Expected result:** Empty data shows `No customers available`; failures show a human-readable error and no visible retry button. No fabricated customer option is added.
- **Result:** Not executed.

### RT-08 — Delivery Edit submission preserves selected customer

- **Scenario:** Update a delivery after the existing customer is selected from API data.
- **Preconditions/setup:** Delivery and customer APIs return valid records; PUT endpoint is available.
- **Steps:** Confirm or change the customer, update valid delivery fields, and submit.
- **Expected result:** `PUT /api/deliveries/{id}` receives the selected `customer_id`; existing delivery date/status handling and success/validation feedback remain unchanged.
- **Result:** Not executed.

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
- **Expected result:** Equivalent actions use equivalent feedback patterns; resource-specific wording and authorization rules remain clear. Detail and relationship-loading states reflect the active API/state behavior documented above.
- **Result:** Not executed.
