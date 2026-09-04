# Guard Clause Verification Matrix

| Endpoint | Test Case | Sent Payload | Expected Status | Result Status |
| :--- | :--- | :--- | :--- | :--- |
| `POST /customers` | Empty Name | `{"contact_number": "09123456789"}` | `422` | `422` |
| `POST /products` | Negative Price | `{"name": "Pen", "price": -5, "stock": 10}` | `422` | `422` |
| `POST /orders` | Invalid Quantity | `{"customer_id": 1, "product_id": 1, "quantity": 0}` | `422` | `422` |
| `POST /deliveries` | Bad Status | `{"customer_id": 1, "delivery_date": "2026-09-01", "status": "unknown"}` | `422` | `422` |