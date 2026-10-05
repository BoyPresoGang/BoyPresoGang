# Shared Blade UI Components

## Overview

This document lists the reusable Blade UI components used by the Water Refilling Station Management System. The components are designed to keep the interface consistent across Customers, Products, Orders, and Deliveries screens.

The shared components are located in:

resources/views/components/

---

## Shared Components

### 1. Page Header

**File:**
resources/views/components/page-header.blade.php

**Purpose:**
Provides a reusable page title and optional description.

**Used for:**
- Customer pages
- Product pages
- Order pages
- Delivery pages

**Example:**
<x-page-header
    title="Customers"
    description="Manage customer records."
/>

---

### 2. Card

**File:**
resources/views/components/card.blade.php

**Purpose:**
Provides a consistent white content container with border, rounded corners, and spacing.

**Used for:**
- Detail screens
- Create forms
- Edit forms
- Other grouped content areas

**Example:**
<x-card>
    <!-- Page content -->
</x-card>

---

### 3. Form Field

**File:**
resources/views/components/form-field.blade.php

**Purpose:**
Provides consistent spacing and styling for form labels and form controls.

**Used for:**
- Customer Create/Edit forms
- Product Create/Edit forms
- Order Create/Edit forms
- Delivery Create/Edit forms

**Example:**
<x-form-field label="Customer Name" id="name">
    <input
        type="text"
        id="name"
        name="name"
        required
    >
</x-form-field>

---

### 4. Button

**File:**
resources/views/components/button.blade.php

**Purpose:**
Provides consistent styling for primary and secondary actions.

**Used for:**
- Create actions
- Update actions
- View actions
- Edit actions
- Cancel actions
- Other page actions

**Example:**
<x-button type="submit">
    Save Customer
</x-button>

For a secondary link:

<x-button
    type="link"
    href="#"
    variant="secondary"
>
    Cancel
</x-button>

---

# Screen-to-Component Mapping

## Customers

| Screen | Components |
|---|---|
| Customer List | Page Header, Card, Button |
| Customer Details | Page Header, Card, Button |
| Create Customer | Page Header, Card, Form Field, Button |
| Edit Customer | Page Header, Card, Form Field, Button |

## Products

| Screen | Components |
|---|---|
| Product List | Page Header, Card, Button |
| Product Details | Page Header, Card, Button |
| Create Product | Page Header, Card, Form Field, Button |
| Edit Product | Page Header, Card, Form Field, Button |

## Orders

| Screen | Components |
|---|---|
| Order List | Page Header, Card, Button |
| Order Details | Page Header, Card, Button |
| Create Order | Page Header, Card, Form Field, Button |
| Edit Order | Page Header, Card, Form Field, Button |

## Deliveries

| Screen | Components |
|---|---|
| Delivery List | Page Header, Card, Button |
| Delivery Details | Page Header, Card, Button |
| Create Delivery | Page Header, Card, Form Field, Button |
| Edit Delivery | Page Header, Card, Form Field, Button |

---

# Component Design Principles

The shared components follow these principles:

- **Reuse** — common interface elements are defined once and can be reused across multiple screens.
- **Consistency** — shared components maintain consistent spacing, styling, and interaction patterns.
- **Readability** — pages can be composed from named components instead of repeating large blocks of markup.
- **Accessibility** — form controls and interactive elements use semantic HTML and visible focus states.
- **Maintainability** — changes to shared UI elements can be made in one component instead of modifying every screen individually.

---

# Week 6 Integration

The shared components support the Week 6 requirement to break wireframes into reusable pieces and compose screens from those pieces.

The components are currently designed for static Blade views using placeholder/sample data. Real backend data binding and interactive form submission will be handled in the following development phase.

---

# Implementation Attribution

The shared Blade UI components documented in this file were implemented as part of the Week 6 shared-component work.

- **Contributor:** Jerfrans
- **Related work:** Shared Blade UI Components
- **Commits:** `2b79549`, `d8cd385`

The repository history verifies the implementation commits, but does not by itself establish whether each component was AI-generated, AI-modified, or hand-written. No unsupported AI attribution is made here.