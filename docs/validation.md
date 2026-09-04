# Validation Matrix

## Customers

| Route | Field | Rules |
| :--- | :--- | :--- |
| POST /customers | name | required, string, 2-100 chars |
| POST /customers | contact_number | required, string, 7-20 chars, unique |
| PUT /customers | name | sometimes, string, 2-100 chars |
| PUT /customers | contact_number | sometimes, string, 7-20 chars, unique |

## Products

| Route | Field | Rules |
| :--- | :--- | :--- |
| POST /products | name | required, string, 2-150 chars |
| POST /products | price | required, number, greater than 0 |
| POST /products | stock | required, integer, 0 or greater |
| PUT /products | name | sometimes, string, 2-150 chars |
| PUT /products | price | sometimes, number, greater than 0 |
| PUT /products | stock | sometimes, integer, 0 or greater |

## Orders

| Route | Field | Rules |
| :--- | :--- | :--- |
| POST /orders | customer_id | required, integer, referential (exists in customers) |
| POST /orders | product_id | required, integer, referential (exists in products) |
| POST /orders | quantity | required, integer, 1 or greater |
| PUT /orders | customer_id | sometimes, integer, referential (exists in customers) |
| PUT /orders | product_id | sometimes, integer, referential (exists in products) |
| PUT /orders | quantity | sometimes, integer, 1 or greater |

## Deliveries

| Route | Field | Rules |
| :--- | :--- | :--- |
| POST /deliveries | customer_id | required, integer, referential (exists in customers) |
| POST /deliveries | delivery_date | required, date, format YYYY-MM-DD |
| POST /deliveries | status | required, one of (scheduled, in_transit, delivered, cancelled) |
| PUT /deliveries | customer_id | sometimes, integer, referential (exists in customers) |
| PUT /deliveries | delivery_date | sometimes, date, format YYYY-MM-DD |
| PUT /deliveries | status | sometimes, one of (scheduled, in_transit, delivered, cancelled) |

### Customers Testing Log
| Test Case | Payload / Header | Expected | Result |
| :--- | :--- | :--- | :--- |
| Missing Name | `{}` | 422 | 422 |
| Non-Admin Delete | Header `X-User-Role: user` | 403 | 403 |

### Products Testing Log
| Test Case | Payload / Header | Expected | Result |
| :--- | :--- | :--- | :--- |
| Price as String | `{"price": "cake"}` | 422 | 422 |
| Non-Manager Edit | Header `X-User-Role: clerk` | 403 | 403 |

### Orders Testing Log
| Test Case | Payload / Header | Expected | Result |
| :--- | :--- | :--- | :--- |
| Zero Quantity | `{"quantity": 0}` | 422 | 422 |
| Unauthorized Edit | Header `X-User-Id: 200` | 403 | 403 |