# Week 9 — Find the AI Flaw

## Flaw Identified

### Product deletion can orphan existing Orders

The application allows a Product to be deleted even when existing Orders still reference it.

## What Is Wrong

`ProductController::deleteProduct()` authorizes the request, finds the Product, and deletes it without checking whether Orders reference that Product.

The Order cancellation flow depends on the Product still existing so it can restore the Order quantity to Product stock. When the Product has been deleted, the Order remains with its old `product_id`, but the Product can no longer be found.

## Why It Is Wrong

The Order lifecycle cannot complete normally after its Product is deleted:

- The Order becomes orphaned from its Product.
- The Order cannot be cancelled/deleted through the current flow.
- The related quantity cannot be restored.
- Multiple Orders referencing the deleted Product can be affected.
- Order list/detail views may show an unavailable Product.

The current code correctly avoids restoring stock when the Product is missing. The flaw is that the Order remains stuck in the database and its lifecycle cannot complete.

## Evidence

- `app/Http/Controllers/ProductController.php`
  - `deleteProduct()` deletes the Product without checking related Orders.
- `app/Http/Controllers/OrderController.php`
  - `deleteOrder()` locks the Order, checks the requesting user, and then looks up the Product to restore stock.
  - If the Product is missing, `productUnavailableError()` returns HTTP 422 and the Order is not deleted.
- `database/migrations/2026_09_04_095525_create_orders_table.php`
  - `product_id` is stored without a database-level foreign-key constraint to Products.
- `app/Models/Order.php`
  - The Order has a Product relationship, but the relationship alone does not enforce database referential integrity.

## Failure Scenario

1. A Product exists.
2. An Order references that Product.
3. The Product is deleted.
4. The Order remains with its old `product_id`.
5. The user attempts to cancel/delete the Order.
6. The Product cannot be found.
7. The API returns HTTP 422: `The selected product is no longer available.`
8. The Order remains in the database.
9. Stock is not restored.

## Recommended Fix

The smallest application-level fix is to prevent Product deletion when existing Orders reference it. The API should return a clear HTTP 422 or 409 response explaining that the Product cannot be deleted while it is referenced by Orders.

Possible longer-term alternatives are:

- Add a database foreign-key restriction.
- Use product archiving or soft deletion for Products referenced by historical Orders.

These fixes were not implemented as part of this investigation.

## Validation

The flaw was independently inspected and confirmed by two team members. No automated tests are claimed because PHP was unavailable during the investigation.