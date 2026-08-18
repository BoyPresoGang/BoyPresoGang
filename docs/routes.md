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
| `PUT` | `/products/:id` | `updateProduct` | P4 – Update Product |
| `DELETE` | `/products/:id` | `deleteProduct` | P5 – Delete Product |

---

## Orders

| Method | Path | Handler | Story it serves |
|---|---|---|---|
| `POST` | `/orders` | `createOrder` | O1 – Create Order |
| `GET` | `/orders` | `listOrders` | O2 – View Order List |
| `GET` | `/orders/:id` | `showOrder` | O3 – View Order Details |
| `PUT` | `/orders/:id` | `updateOrder` | O4 – Update Order |
| `DELETE` | `/orders/:id` | `deleteOrder` | O5 – Delete Order |

---

## Deliveries

| Method | Path | Handler | Story it serves |
|---|---|---|---|
| `POST` | `/deliveries` | `createDelivery` | D1 – Create Delivery |
| `GET` | `/deliveries` | `listDeliveries` | D2 – View Delivery List |
| `GET` | `/deliveries/:id` | `showDelivery` | D3 – View Delivery Details |
| `PUT` | `/deliveries/:id` | `updateDelivery` | D4 – Update Delivery |
| `DELETE` | `/deliveries/:id` | `deleteDelivery` | D5 – Delete Delivery |