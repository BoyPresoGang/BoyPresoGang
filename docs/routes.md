# API Routes

## 1. Route Definitions

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

## 2. Test Execution Logs

### Customers Test Results

* **C1 – Create Customer**
  * **Request:** `POST http://127.0.0.1:8000/api/customers`
  * **Status:** `201 Created`
  * **Response Body:** `{"message": "createCustomer stub"}`

* **C2 – View Customer List**
  * **Request:** `GET http://127.0.0.1:8000/api/customers`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "listCustomers stub"}`

* **C3 – View Customer Details**
  * **Request:** `GET http://127.0.0.1:8000/api/customers/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "showCustomer stub", "id": "1"}`

* **C4 – Update Customer**
  * **Request:** `PUT http://127.0.0.1:8000/api/customers/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "updateCustomer stub", "id": "1"}`

* **C5 – Delete Customer**
  * **Request:** `DELETE http://127.0.0.1:8000/api/customers/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "deleteCustomer stub", "id": "1"}`

### Products Test Results

* **P1 – Create Product**
  * **Request:** `POST http://127.0.0.1:8000/api/products`
  * **Status:** `201 Created`
  * **Response Body:** `{"message": "createProduct stub"}`

* **P2 – View Product List**
  * **Request:** `GET http://127.0.0.1:8000/api/products`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "listProducts stub"}`

* **P3 – View Product Details**
  * **Request:** `GET http://127.0.0.1:8000/api/products/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "showProduct stub", "id": "1"}`

* **P4 – Update Product**
  * **Request:** `PUT http://127.0.0.1:8000/api/products/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "updateProduct stub", "id": "1"}`

* **P5 – Delete Product**
  * **Request:** `DELETE http://127.0.0.1:8000/api/products/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "deleteProduct stub", "id": "1"}`

### Orders Test Results

* **O1 – Create Order**
  * **Request:** `POST http://127.0.0.1:8000/api/orders`
  * **Status:** `201 Created`
  * **Response Body:** `{"message": "createOrder stub"}`

* **O2 – View Order List**
  * **Request:** `GET http://127.0.0.1:8000/api/orders`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "listOrders stub"}`

* **O3 – View Order Details**
  * **Request:** `GET http://127.0.0.1:8000/api/orders/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "showOrder stub", "id": "1"}`

* **O4 – Update Order**
  * **Request:** `PUT http://127.0.0.1:8000/api/orders/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "updateOrder stub", "id": "1"}`

* **O5 – Delete Order**
  * **Request:** `DELETE http://127.0.0.1:8000/api/orders/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "deleteOrder stub", "id": "1"}`

### Deliveries Test Results

* **D1 – Create Delivery**
  * **Request:** `POST http://127.0.0.1:8000/api/deliveries`
  * **Status:** `201 Created`
  * **Response Body:** `{"message": "createDelivery stub"}`

* **D2 – View Delivery List**
  * **Request:** `GET http://127.0.0.1:8000/api/deliveries`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "listDeliveries stub"}`

* **D3 – View Delivery Details**
  * **Request:** `GET http://127.0.0.1:8000/api/deliveries/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "showDelivery stub", "id": "1"}`

* **D4 – Update Delivery**
  * **Request:** `PUT http://127.0.0.1:8000/api/deliveries/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "updateDelivery stub", "id": "1"}`

* **D5 – Delete Delivery**
  * **Request:** `DELETE http://127.0.0.1:8000/api/deliveries/1`
  * **Status:** `200 OK`
  * **Response Body:** `{"message": "deleteDelivery stub", "id": "1"}`