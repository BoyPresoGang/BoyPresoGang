# Week 7 Binding Tests

## Purpose

This document records the end-to-end binding tests for the Week 7 Create and Update forms.

The Week 7 requirements are to verify that:

- Create operations persist successfully.
- Update operations persist successfully.
- Invalid data returns a `422` validation response.

## Create Form Tests

### Customer Create

| Test | Input | Expected Result | Actual Result | Status |
|---|---|---|---|---|
| Create valid customer | Name: Juan Dela Cruz; Contact: 09123456789 | Customer is created and persisted | Customer created successfully and form cleared | PASS |

### Product Create

| Test | Input | Expected Result | Actual Result | Status |
|---|---|---|---|---|
| Create valid product | Name: 5-Gallon Purified Water; Price: 25; Stock: 10 | Product is created and persisted | Product created successfully and form cleared | PASS |
| Invalid price | Price: 0 | API returns HTTP 422 | HTTP 422 returned with `price` validation error | PASS |

### Order Create

| Test | Input | Expected Result | Actual Result | Status |
|---|---|---|---|---|
| Create valid order | Customer: 1; Product: 1; Quantity: valid quantity | Order is created and persisted | Order created successfully | PASS |
| Invalid quantity | Quantity: 0 | API returns HTTP 422 | HTTP 422 returned with `quantity` validation error | PASS |

### Delivery Create

| Test | Input | Expected Result | Actual Result | Status |
|---|---|---|---|---|
| Create valid delivery | Customer: 1; Valid delivery date; Status: Scheduled | Delivery is created and persisted | Delivery created successfully | PASS |
| Invalid delivery date | Delivery date: `not-a-date` | API returns HTTP 422 | HTTP 422 returned with `delivery_date` validation error | PASS |

## Update Form Tests

| Test | Input | Expected Result | Actual Result | Status |
|---|---|---|---|---|
| Customer Update persists | Customer 1; Contact: `09123456789` | Updated customer data persists | Customer updated successfully; response returned HTTP 200 and updated contact number | PASS |
| Product Update persists | Product 1; Name: `Drugs Updated`; Price: `450`; Stock: `75` | Updated product data persists | Product updated successfully; response returned HTTP 200 with updated values | PASS |
| Order Update persists | Order 1; Quantity: `6` | Updated order data persists | Order updated successfully; response returned HTTP 200 with quantity `6` | PASS |
| Delivery Update persists | Delivery 1; Date: `2026-10-15`; Status: `in_transit` | Updated delivery data persists | Delivery updated successfully; response returned HTTP 200 with updated values | PASS |
| Invalid Customer Update returns 422 | Name: empty | API returns HTTP 422 | HTTP 422 returned with `name` validation error | PASS |
| Invalid Product Update returns 422 | Price: `0` | API returns HTTP 422 | HTTP 422 returned with `price` validation error | PASS |
| Invalid Order Update returns 422 | Quantity: `0` | API returns HTTP 422 | HTTP 422 returned with `quantity` validation error | PASS |
| Invalid Delivery Update returns 422 | Delivery date: `not-a-date` | API returns HTTP 422 | HTTP 422 returned with `delivery_date` validation error | PASS |

## Notes

The Create form tests were performed against the Week 7 API endpoints and browser forms.

Validation responses were verified using HTTP requests and confirmed to return HTTP `422` with the affected field and validation message.

The Update form tests were performed against the Week 7 API endpoints. Each resource was tested for successful update persistence and invalid-data validation.

All four Update resources passed both successful-update and `422` validation tests.