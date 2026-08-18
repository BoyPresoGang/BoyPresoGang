# API Routes

## Customers

| Method | Path | Handler | Story it serves |
|---|---|---|---|
| `POST` | `/customers` | `createCustomer` | C1 – Create Customer |
| `GET` | `/customers` | `listCustomers` | C2 – View Customer List |
| `GET` | `/customers/:id` | `showCustomer` | C3 – View Customer Details |
| `PUT` | `/customers/:id` | `updateCustomer` | C4 – Update Customer |
| `DELETE` | `/customers/:id` | `deleteCustomer` | C5 – Delete Customer |

---

## Products

| Method | Path | Handler | Story it serves |
|---|---|---|---|
| `POST` | `/products` | `createProduct` | P1 – Create Product |
| `GET` | `/products` | `listProducts` | P2 – View Product List |
| `GET` | `/products/:id` | `showProduct` | P3 – View Product Details |