# Product Backlog

# Water Refilling Station Management System

This backlog contains the CRUD user stories and acceptance criteria for the Water Refilling Station Management System.

---

# Customers

## Story C1 – Create Customer

### User Story
As a staff member, I want to add a new customer so that customer information can be stored in the system.

### Acceptance Criteria
- Customer name cannot be empty.
- Contact number cannot be empty.
- Duplicate customer records are not created.
- After saving, the new customer appears in the customer list.

---

## Story C2 – View Customer List

### User Story
As a staff member, I want to view the list of customers so that I can quickly find customer records.

### Acceptance Criteria
- Displays all existing customer records.
- Shows each customer's name and contact number.
- If no customers exist, an empty state message is displayed.
- Newly added customers appear in the list immediately.

---

## Story C3 – View Customer Details

### User Story
As a staff member, I want to view a customer's complete information so that I can verify their details.

### Acceptance Criteria
- Only existing customers can be opened.
- Displays the customer's complete information.
- Displays the customer's associated orders.
- If the customer does not exist, an error message is displayed.

---

## Story C4 – Update Customer

### User Story
As a staff member, I want to edit customer information so that records remain accurate.

### Acceptance Criteria
- Only existing customers can be edited.
- Customer name and contact number cannot be empty.
- After saving, the customer list displays the updated information.
- Changes are saved successfully.

---

## Story C5 – Delete Customer

### User Story
As a staff member, I want to remove customer records that are no longer needed.

### Acceptance Criteria
- A confirmation message is displayed before deletion.
- Deleted customers no longer appear in the customer list.
- Customer details cannot be accessed after deletion.

# Products

## Story P1 – Create Product

### User Story
As a staff member, I want to add new products so they become available for orders.

### Acceptance Criteria
- Product name cannot be empty.
- Product price must be greater than 0.
- Stock quantity cannot be negative.
- After saving, the new product appears in the product list.

---

## Story P2 – View Product List

### User Story
As a staff member, I want to view all products so that I can monitor available inventory.

### Acceptance Criteria
- Displays all available products.
- Shows product name, price, and stock quantity.
- If no products exist, an empty state message is displayed.
- Newly added products appear in the list immediately.

---

## Story P3 – View Product Details

### User Story
As a staff member, I want to view detailed product information so that I can verify inventory details.

### Acceptance Criteria
- Only existing products can be opened.
- Displays the product name, price, and stock quantity.
- If the product does not exist, an error message is displayed.

---

## Story P4 – Update Product

### User Story
As a staff member, I want to edit product information so inventory remains accurate.

### Acceptance Criteria
- Only existing products can be edited.
- Product price must be greater than 0.
- Stock quantity cannot be negative.
- After saving, the product list displays the updated information.

---

## Story P5 – Delete Product

### User Story
As a staff member, I want to remove discontinued products from the system.

### Acceptance Criteria
- A confirmation message is displayed before deletion.
- Deleted products no longer appear in the product list.
- Deleted product details cannot be accessed.

# Orders

## Story O1 – Create Order

### User Story
As a staff member, I want to create customer orders so purchases are recorded.

### Acceptance Criteria
- A customer must be selected before saving.
- At least one product must be selected.
- Order quantity must be greater than 0.
- After saving, the new order appears in the order list.

---

## Story O2 – View Order List

### User Story
As a staff member, I want to view all customer orders so I can monitor transactions.

### Acceptance Criteria
- Displays all customer orders.
- Shows customer name, ordered product, and order status.
- If no orders exist, an empty state message is displayed.
- Newly created orders appear in the list immediately.

---

## Story O3 – View Order Details

### User Story
As a staff member, I want to view complete order information so I can verify order details.

### Acceptance Criteria
- Only existing orders can be opened.
- Displays customer information and ordered products.
- Displays the delivery status.
- If the order does not exist, an error message is displayed.

---

## Story O4 – Update Order

### User Story
As a staff member, I want to modify customer orders before delivery if needed.

### Acceptance Criteria
- Only existing orders can be opened for editing.
- Order quantity must be greater than 0.
- Customer and product selections cannot be empty.
- After saving, the order list displays the updated information.

---

## Story O5 – Delete Order

### User Story
As a staff member, I want to cancel or remove incorrect orders.

### Acceptance Criteria
- A confirmation message is displayed before deletion.
- Deleted orders no longer appear in the order list.
- Deleted order details cannot be accessed.

# Deliveries

## Story D1 – Create Delivery

### User Story
As a staff member, I want to schedule deliveries so customer orders can be delivered.

### Acceptance Criteria
- A customer must be selected before saving.
- Delivery date is required.
- Delivery schedule cannot be empty.
- After saving, the new delivery appears in the delivery list.

---

## Story D2 – View Delivery List

### User Story
As a staff member, I want to view scheduled deliveries so I can monitor daily deliveries.

### Acceptance Criteria
- Displays all scheduled deliveries.
- Shows customer name, delivery date, and delivery status.
- If no deliveries exist, an empty state message is displayed.
- Newly scheduled deliveries appear in the list immediately.

---

## Story D3 – View Delivery Details

### User Story
As a staff member, I want to view complete delivery information so I can verify delivery records.

### Acceptance Criteria
- Only existing deliveries can be opened.
- Displays customer information, delivery schedule, and delivery status.
- If the delivery does not exist, an error message is displayed.

---

## Story D4 – Update Delivery

### User Story
As a staff member, I want to update delivery schedules or status so records remain accurate.

### Acceptance Criteria
- Only existing deliveries can be opened for editing.
- Delivery date cannot be empty.
- Delivery status must be selected from the available options.
- After saving, the delivery list displays the updated information.

---

## Story D5 – Delete Delivery

### User Story
As a staff member, I want to remove cancelled delivery records.

### Acceptance Criteria
- A confirmation message is displayed before deletion.
- Deleted deliveries no longer appear in the delivery list.
- Deleted delivery details cannot be accessed.

---

# Summary

**Record Types**

- Customers
- Products
- Orders
- Deliveries

**Total User Stories**

- Customers: 5
- Products: 5
- Orders: 5
- Deliveries: 5

**Total Stories: 20**