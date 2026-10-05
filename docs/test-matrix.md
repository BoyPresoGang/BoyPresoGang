# Week 10 Manual QA Test Matrix

Results below are based only on the explicitly reported QA results and the browser checks executed during this QA session. `NOT TESTED` means no result was claimed. No application code was changed.

## Customers

| Feature | Happy | Boundary | Invalid | Empty | Permissions | Result |
|---|---|---|---|---|---|---|
| Customer list | Load current records from `GET /api/customers`; verify ID, name, and contact number. | Verify one record and many records. | Verify human-readable 500/network error and retry. | Verify the empty-list state. | Verify no unauthorized action is exposed. | Happy PASS; Boundary PASS; Invalid PASS; Empty NOT TESTED; Permissions NOT TESTED |
| Create customer | Create with a valid name and exactly 11-digit contact number. | Test name limits and exactly 11 digits. | Test missing/short/long name and incorrect contact length; verify 422. | Submit with all fields empty. | Verify normal create access. | Happy PASS; Boundary PASS; Invalid PASS; Empty NOT TESTED; Permissions NOT TESTED |
| Customer detail | Load a valid customer and verify data, Edit, and Back links. | Test first and later customer IDs. | Test nonexistent ID, server/network failure, and retry. | Verify missing-data error state. | Verify no unauthorized destructive action. | Happy PASS; Boundary NOT TESTED; Invalid PASS for nonexistent ID; Empty NOT TESTED; Permissions NOT TESTED |
| Edit customer | Load `/customers/edit/{id}` and update valid data. | Test name limits and exactly 11-digit contact. | Test malformed/nonexistent ID and invalid fields; verify 422. | Submit cleared fields. | Verify edit does not require delete authorization. | Happy PASS; Boundary PASS; Invalid PASS; Empty NOT TESTED; Permissions NOT TESTED |
| Delete customer | Confirm deletion of an existing customer and verify list refresh. | Delete the only customer. | Test nonexistent customer, 500, and network failure. | Verify list after final deletion. | Send `X-User-Role: admin`; verify incorrect role returns 403. | Happy PASS; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |

## Products

| Feature | Happy | Boundary | Invalid | Empty | Permissions | Result |
|---|---|---|---|---|---|---|
| Product list | Load current products with name, price, and stock. | Verify many products; zero-stock product remains untested. | Verify 500/network error and retry. | Verify empty-product state. | Verify list access. | Happy PASS; Boundary PASS for many products, zero stock NOT TESTED; Invalid PASS; Empty NOT TESTED; Permissions NOT TESTED |
| Create product | Create with valid name, positive price, and non-negative integer stock. | Test minimum name, price just above zero, and stock zero. | Test invalid name, price, and stock; verify 422. | Submit all fields empty. | Verify normal create access. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Product detail | Load a valid product and verify values, Edit, and Back links. | Verify zero-stock and different valid IDs. | Test nonexistent ID, server/network failure, and retry. | Verify missing-product error state. | Verify detail access. | Happy PASS; Boundary NOT TESTED; Invalid PASS for nonexistent ID; Empty NOT TESTED; Permissions NOT TESTED |
| Edit product | Load the correct path ID and update valid data. | Test zero stock and field limits. | Test malformed/nonexistent ID and invalid fields; verify 422. | Submit cleared fields. | Verify edit does not require manager delete authorization. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Delete product | Delete an existing product with manager authorization. | Delete the final product. | Test nonexistent product, 500, and network failure. | Verify final empty state. | Send `X-User-Role: manager`; verify missing/incorrect role returns 403. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Product–Order integrity | Delete a product with no orders. | Test one and multiple referencing orders. | Delete a referenced product, then cancel its order; verify unavailable-product 422 and retained order. | Verify unrelated products do not affect orders. | Verify product-delete authorization. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |

## Orders

| Feature | Happy | Boundary | Invalid | Empty | Permissions | Result |
|---|---|---|---|---|---|---|
| Order list | Load orders and verify customer/product names, ID, and quantity. | Verify one/many orders and zero-stock products. | Test 500/network failure and retry. | Verify empty-order state. | Verify list access. | Happy PASS; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Order create and relationship dropdowns | Load current customer/product options and submit a valid order. | Test quantity 1 and quantity exactly equal to stock. | Test invalid IDs, unavailable product, invalid quantity, and quantity above stock; verify 422. | Verify no-options loading/empty states. | Verify no creation header is required. | Happy NOT TESTED; Boundary NOT TESTED; Invalid FAIL for over-stock UI feedback; Empty NOT TESTED; Permissions NOT TESTED |
| Order detail | Load a valid order and verify names, quantity, Edit, and Back. | Verify first/later order IDs. | Test nonexistent ID, malformed response, server/network failure, and retry. | Verify not-found/error state. | Verify no unauthorized cancellation control. | Happy PASS; Boundary NOT TESTED; Invalid PASS for nonexistent ID; Empty NOT TESTED; Permissions NOT TESTED |
| Edit order | Load the correct order and update valid customer/product/quantity. | Test same quantity, exact available stock, and product changes. | Test invalid references, insufficient stock, and server/network failure. | Verify option-loading empty states. | Verify edit does not require cancellation authorization. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Cancel/delete order | Confirm cancellation and verify deletion plus one-time stock restoration. | Test final order and restored stock. | Test nonexistent order, missing product, 500, and network failure. | Verify empty order list. | Matching `X-User-Id` succeeds; other/missing IDs return 403. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |

## Deliveries

| Feature | Happy | Boundary | Invalid | Empty | Permissions | Result |
|---|---|---|---|---|---|---|
| Delivery list | Load delivery records with customer, product, quantity, date, status, and actions. | Verify all current statuses. | Test 500/network failure and retry. | Verify empty state. | Verify list access. | Happy PASS; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Delivery create and eligible orders | Load eligible orders and create a delivery with valid date/status. | Today is allowed; future dates are allowed. | Test past date, invalid status, missing/nonexistent order, and duplicate active order. | Verify no eligible-orders message. | Verify creation does not require dispatcher authorization. | Happy NOT TESTED; Boundary PASS for date minimum being set to today; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Delivery edit | Load the correct delivery and update valid order/date/status. | Current order remains selectable; test today/future dates. | Test past date, invalid status, duplicate order, and API/network failure. | Verify no eligible orders and legacy handling. | Verify edit access. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Delivery detail | Load a valid delivery and verify customer, product, quantity, date, status, Edit, and Back. | Verify status variants and legacy delivery without an order. | Test nonexistent ID, malformed response, server/network failure, and retry. | Verify not-found/error state. | Verify detail does not bypass cancellation authorization. | Happy PASS; Boundary PASS for legacy delivery handling; Invalid PASS for nonexistent ID; Empty NOT TESTED; Permissions NOT TESTED |
| Cancel delivery | Confirm cancellation and verify status changes to `cancelled` without deletion. | Test scheduled and in-transit deliveries. | Test nonexistent delivery, 500, and network failure. | Verify final-list state. | `X-User-Role: dispatcher` succeeds; incorrect role returns 403. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Duplicate delivery prevention | Create one active delivery for an order. | Test scheduled/in-transit active and delivered/cancelled non-active statuses. | Attempt a second active delivery and verify 422 on `order_id`. | Verify no eligible orders when all are occupied. | Verify backend enforcement cannot be bypassed. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |

## System-level and cross-feature flows

| Feature | Happy | Boundary | Invalid | Empty | Permissions | Result |
|---|---|---|---|---|---|
| Navigation | Verify list/create/detail/edit/back links use the correct resource and ID. | Test first and later IDs. | Verify only retry controls retain intentional `href="#"`. | Verify navigation from empty/error states. | Verify navigation does not bypass authorization. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Async feedback consistency | Verify loading, success, and post-action refresh feedback. | Test slow responses and refresh after actions. | Test 403, 404, 422, 500, network, and malformed responses. | Verify list, dropdown, and detail empty states. | Keep permission failures distinct from other errors. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Demo authorization mechanism | Verify authorized customer, product, order, and delivery actions. | Test each expected header. | Remove/alter headers and verify 403 feedback. | Not applicable. | Admin customer delete, manager product delete, matching order customer ID, dispatcher delivery cancel. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Order stock lifecycle | Verify create deduction, update adjustment, and cancellation restoration. | Test exact stock, zero stock, same product, product switch, and multiple orders. | Test over-stock, failed operations, missing product, and repeated cancellation. | Verify unavailable products cannot be selected. | Verify existing authorization remains intact. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Order–Delivery lifecycle | Create an order, create one delivery, cancel it, and verify re-eligibility. | Test active, delivered, and cancelled statuses. | Test duplicate delivery and invalid order/date/status. | Verify no eligible orders when all are occupied. | Delivery cancellation requires dispatcher authorization. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| Atomicity and concurrency | Verify related records remain consistent after successful operations. | Submit competing stock/delivery requests where feasible. | Verify failed operations do not partially change state. | Verify consistency after failed refreshes. | Backend checks remain effective when UI restrictions are bypassed. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |
| API/CRUD contract | Verify successful list/create/show/update/delete responses and refreshes. | Test one record, final record, and repeated valid operations. | Verify standardized 403/404/422/500/network behavior. | Verify empty collections and missing relationships. | Verify headers are sent only for intended destructive actions. | Happy NOT TESTED; Boundary NOT TESTED; Invalid NOT TESTED; Empty NOT TESTED; Permissions NOT TESTED |

## QA Results and observations

### Confirmed failure

- **Order create — quantity above available stock:** Selected `Ring of Regen` with available stock `1`, entered quantity `2`, and submitted. The form remained on the page with no visible validation or error message; a backend 422 response was not observed. This should be investigated as a user-feedback issue.

### Other observations

- The Order list currently contains an order whose product displays as **“Product unavailable”**. This is consistent with the previously identified Product–Order orphan scenario and should be considered for Week 10 bug reporting.
- The Delivery list/detail currently display legacy deliveries as **“No associated order”**, with quantity `—`; this behavior was visible and should be retained in the QA record.
- The Delivery Create date input exposed `min="2026-10-06"`, matching the local QA date, but past/today/future submissions were not fully exercised.

### Not tested

The matrix entries explicitly labeled `NOT TESTED` remain unexecuted. In particular, destructive authorization flows, order stock mutation, Delivery cancellation, duplicate-delivery prevention, empty states, server/network fault injection beyond the explicitly reported customer/product results, concurrency, and the full create/edit flows were not claimed as executed.
