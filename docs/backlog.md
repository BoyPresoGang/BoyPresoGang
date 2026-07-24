# Product Backlog

# Water Refilling Station Management System

This backlog contains the CRUD user stories and acceptance criteria for the Water Refilling Station Management System.

---

# Customers

## Story C1 – Create Customer

**User Story**

As a staff member, I want to add a new customer so that customer information can be stored in the system.

**Acceptance Criteria**

- Customer name is required.
- Contact number is required.
- Customer record is saved successfully.

---

## Story C2 – View Customer List

**User Story**

As a staff member, I want to view the list of customers so that I can quickly find customer records.

**Acceptance Criteria**

- Displays all customers.
- Shows customer name and contact number.
- Displays an empty state if there are no customers.

---

## Story C3 – View Customer Details

**User Story**

As a staff member, I want to view a customer's complete information so that I can verify their details.

**Acceptance Criteria**

- Displays customer information.
- Shows associated customer orders.
- Displays an error if the customer does not exist.

---

## Story C4 – Update Customer

**User Story**

As a staff member, I want to edit customer information so that records remain accurate.

**Acceptance Criteria**

- Existing customer information can be modified.
- Required fields cannot be left empty.
- Changes are saved successfully.

---

## Story C5 – Delete Customer

**User Story**

As a staff member, I want to remove customer records that are no longer needed.

**Acceptance Criteria**

- Confirmation is required before deletion.
- Deleted customer no longer appears in the customer list.

---

# Products

## Story P1 – Create Product

**User Story**

As a staff member, I want to add new products so they become available for orders.

**Acceptance Criteria**

- Product name is required.
- Product price is required.
- Product is saved successfully.

---

## Story P2 – View Product List

**User Story**

As a staff member, I want to view all products so that I can monitor available inventory.

**Acceptance Criteria**

- Displays every product.
- Shows price and stock quantity.
- Displays an empty state if no products exist.

---

## Story P3 – View Product Details

**User Story**

As a staff member, I want to view detailed product information so that I can verify inventory details.

**Acceptance Criteria**

- Displays product name.
- Displays stock quantity.
- Displays product price.

---

## Story P4 – Update Product

**User Story**

As a staff member, I want to edit product information so inventory remains accurate.

**Acceptance Criteria**

- Product information can be updated.
- Changes are saved successfully.
- Required fields cannot be empty.

---

## Story P5 – Delete Product

**User Story**

As a staff member, I want to remove discontinued products from the system.

**Acceptance Criteria**

- Confirmation is displayed before deletion.
- Deleted products no longer appear in the list.

---

# Orders

## Story O1 – Create Order

**User Story**

As a staff member, I want to create customer orders so purchases are recorded.

**Acceptance Criteria**

- Customer must be selected.
- Product must be selected.
- Order is saved successfully.

---

## Story O2 – View Order List

**User Story**

As a staff member, I want to view all customer orders so I can monitor transactions.

**Acceptance Criteria**

- Displays all orders.
- Shows customer, product, and order status.
- Displays an empty state if no orders exist.

---

## Story O3 – View Order Details

**User Story**

As a staff member, I want to view complete order information so I can verify order details.

**Acceptance Criteria**

- Displays ordered products.
- Displays customer information.
- Displays delivery status.

---

## Story O4 – Update Order

**User Story**

As a staff member, I want to modify customer orders before delivery if needed.

**Acceptance Criteria**

- Existing order information can be edited.
- Changes are saved successfully.
- Required fields remain valid.

---

## Story O5 – Delete Order

**User Story**

As a staff member, I want to cancel or remove incorrect orders.

**Acceptance Criteria**

- Confirmation is required.
- Deleted orders no longer appear in the order list.

---

# Deliveries

## Story D1 – Create Delivery

**User Story**

As a staff member, I want to schedule deliveries so customer orders can be delivered.

**Acceptance Criteria**

- Delivery date is required.
- Customer must be selected.
- Delivery record is saved successfully.

---

## Story D2 – View Delivery List

**User Story**

As a staff member, I want to view scheduled deliveries so I can monitor daily deliveries.

**Acceptance Criteria**

- Displays every scheduled delivery.
- Shows customer name and delivery status.
- Displays an empty state if no deliveries exist.

---

## Story D3 – View Delivery Details

**User Story**

As a staff member, I want to view complete delivery information so I can verify delivery records.

**Acceptance Criteria**

- Displays customer information.
- Displays delivery schedule.
- Displays delivery status.

---

## Story D4 – Update Delivery

**User Story**

As a staff member, I want to update delivery schedules or status so records remain accurate.

**Acceptance Criteria**

- Delivery schedule can be modified.
- Delivery status can be updated.
- Changes are saved successfully.

---

## Story D5 – Delete Delivery

**User Story**

As a staff member, I want to remove cancelled delivery records.

**Acceptance Criteria**

- Confirmation is displayed before deletion.
- Deleted delivery no longer appears in the delivery list.

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