# Week 8 Feedback Matrix

## Purpose

This matrix specifies the feedback expected for asynchronous actions across Customers, Products, Orders, and Deliveries. It is also a reference for the tests in [`feedback-tests.md`](feedback-tests.md).

The matrix reflects the current Blade implementation. States marked **Gap** are represented in the markup or requirements but are not currently wired to a live interaction.

## Matrix

| Resource/action | Trigger | Loading feedback | Success feedback | 422 behavior | 404 behavior | 500 behavior | Network failure | Retry | Confirmation |
|---|---|---|---|---|---|---|---|---|---|
| Customers — create | Submit customer form | Submit button changes to `Saving...` and is disabled | `Customer created successfully.`; form resets | General form error plus the returned field message inline | General create error; no resource-specific 404 handling | General create error | `A network error occurred...` | Resubmit the form | No |
| Products — create | Submit product form | Submit button changes to `Saving...` and is disabled | `Product created successfully.`; form resets | General form error plus the returned field message inline | General create error; no resource-specific 404 handling | General create error | Network error message | Resubmit the form | No |
| Orders — create | Submit order form | Submit button changes to `Saving...` and is disabled | `Order created successfully.`; form resets | General form error plus the returned field message inline | General create error; no resource-specific 404 handling | General create error | Network error message | Resubmit the form | No |
| Deliveries — create | Submit delivery form | Submit button changes to `Saving...` and is disabled | `Delivery created successfully.`; form resets | General form error plus the returned field message inline | General create error; no resource-specific 404 handling | General create error | Network error message | Resubmit the form | No |
| Customers — update | Submit edit form | Submit button changes to `Updating...` and is disabled | `Customer updated successfully.` | Returned field error is shown inline; otherwise form error | Generic update error; no explicit 404 branch | Generic update error | `A network error occurred. Please try again.` | Resubmit the form | No |
| Products — update | Submit edit form | Submit button changes to `Updating...` and is disabled | `Product updated successfully.` | Returned field error is shown inline; otherwise form error | Generic update error; no explicit 404 branch | Generic update error | Network error message | Resubmit the form | No |
| Orders — update | Submit edit form | Submit button changes to `Updating...` and is disabled | `Order updated successfully.` | Returned field error is shown inline; otherwise form error | Generic update error; no explicit 404 branch | Generic update error | Network error message | Resubmit the form | No |
| Deliveries — update | Submit edit form | Submit button changes to `Updating...` and is disabled | `Delivery updated successfully.` | Returned field error is shown inline; otherwise form error | Generic update error; no explicit 404 branch | Generic update error | Network error message | Resubmit the form | No |
| Customers — list | Page load or list retry | `Loading customers...` state | Table is shown with API rows | Error state for non-200 response; not field-specific | Error state for non-200 response | Error state with human-readable message | Error state with human-readable message | `Try Again` calls the list fetch again | No |
| Products — list | Page load or list retry | `Loading products...` state | Table is shown with API rows and formatted price | Error state for non-200 response | Error state for non-200 response | Error state with human-readable message | Error state with human-readable message | `Try Again` calls the list fetch again | No |
| Orders — list | Page load or list retry | `Loading orders...` state | Table is shown with customer ID, product ID, and quantity | Error state for non-200 response | Error state for non-200 response | Error state with human-readable message | Error state with human-readable message | `Try Again` calls the list fetch again | No |
| Deliveries — list | Page load or list retry | `Loading deliveries...` state | Table is shown with customer ID, date, and status | Error state for non-200 response | Error state for non-200 response | Error state with human-readable message | Error state with human-readable message | `Try Again` calls the list fetch again | No |
| Any list — empty | Successful list response with `data: []` | Loading state ends | Empty state is shown; Create button remains available | Not applicable | Not applicable | Not applicable | Not applicable | List retry remains available only through an error state | No |
| Customers — delete | Click row Delete, then confirm | Row button becomes `Deleting...`; action feedback says `Deleting customer...` | Success message, then list refresh | `The delete request was invalid.` with retry | Not-found message with retry | Server error message with retry | Network error message with retry | `Try Delete Again` repeats the request | Native confirmation required |
| Products — delete | Click row Delete, then confirm | Row button becomes `Deleting...`; action feedback says `Deleting product...` | Success message, then list refresh | `The delete request was invalid.` with retry | Not-found message with retry | Server error message with retry | Network error message with retry | `Try Delete Again` repeats the request | Native confirmation required |
| Orders — cancel | Click row Delete, then confirm | Row button becomes `Cancelling...`; action feedback says `Cancelling order...` | `Order cancelled successfully.`, then list refresh | Cancel-request error with retry | Not-found message with retry | Server error message with retry | Network error message with retry | `Try Delete Again` repeats the request | Native confirmation required |
| Deliveries — cancel | Click row Cancel, then confirm | Row button becomes `Cancelling...`; action feedback says `Cancelling delivery...` | `Delivery cancelled successfully.`, then list refresh; server state is expected to show `cancelled` | Cancel-request error with retry | Not-found message with retry | Server error message with retry | Network error message with retry | `Try Cancel Again` repeats the request | Native confirmation required |
| Customer/product/order/delivery — detail | Open detail page | Static loading markup exists | **Gap:** no active detail-fetch success state is wired in the current show views | **Gap:** not-found markup exists but is not driven by a detail request | Not-found markup exists but is not currently driven by a detail request | **Gap:** error markup exists but is not currently driven by a detail request | **Gap:** no active detail retry implementation | **Gap:** Try Again link is not wired | No |

## Authorization notes

The delete/cancel endpoints enforce authorization on the backend. The current index scripts do not invent or hardcode `X-User-Role` or `X-User-Id` values. Therefore, unauthorized requests should surface the implemented 403 message:

- Customer delete: requires `X-User-Role: admin`.
- Product delete: requires `X-User-Role: manager`.
- Order cancel: requires `X-User-Id` matching the order customer.
- Delivery cancel: requires `X-User-Role: dispatcher` and changes the record status to `cancelled`.
