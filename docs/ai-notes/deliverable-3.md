## Mark — Member 1 List-View API Binding

### AI disclosure
Work was AI-assisted. AI was used to inspect the existing resource list views, assist with binding the Customers, Products, Orders, and Deliveries views to their corresponding API endpoints, and assist with handling asynchronous loading, empty, error, and retry states.

### Implemented changes
- Bound the Customer list view to `/api/customers`.
- Bound the Product list view to `/api/products`.
- Bound the Order list view to `/api/orders`.
- Bound the Delivery list view to `/api/deliveries`.
- Added loading, empty, error, and retry handling for asynchronous list requests.
- Preserved safe DOM rendering and the existing resource actions.

### AI-use classification
- API list bindings — **AI-modified**
- Loading/empty/error/retry handling — **AI-assisted / AI-modified**
- Existing resource structure and routes — **preserved**

## Abdul — Member 2 Detail-Page States/Error Handling

AI assistance was used for Deliverable 3.

Purpose: Correct the detail views so HTTP 404 responses remain distinct from server errors, network failures, and unusable API responses, while preserving the existing detail rendering and retry behavior.

Changed:
- Updated the customer, product, order, and delivery detail Blade views to show loading before each request, render the existing fields for valid responses, show the not-found state only for HTTP 404 (or a missing page ID), and show human-readable errors for other HTTP failures, network failures, and unexpected responses.
- Kept each existing API endpoint, displayed field, and retry action unchanged.

Testing: A Node-based harness with mocked `fetch()` responses and DOM elements exercised loading, successful field rendering, HTTP 404, HTTP 500, rejected fetch/network failure, an unusable data envelope, and retry after failure on all four detail views. `git diff --check` also passed.

Testing limitations: These were simulated client-side checks only. No live browser session or API request was used, so real record data, actual backend 404/500 responses, and an actual connection failure were not verified.

## Rommel — Member 3 Delete/Cancel Flows and Relationship Form Bindings

### AI disclosure
Work was AI-assisted. AI was used to assist with implementing and refining the resource delete/cancellation flows and with binding Order and Delivery relationship fields to API data.

### Implemented changes
- Added delete confirmation, loading, success, and error handling across Customers, Products, Orders, and Deliveries.
- Added delivery cancellation handling.
- Added handling for 403, 404, 422, 500, and network failures with human-readable feedback.
- Added list refresh behavior after successful deletion or cancellation.
- Bound Order Create customer and product selections to API data instead of hardcoded options.
- Bound Delivery Create/Edit customer selections to API data.
- Added loading, empty, and error states for relationship selectors.

### AI-use classification
- Delete/cancellation flow — **AI-assisted / AI-modified**
- Relationship API bindings — **AI-assisted / AI-modified**
- Existing backend authentication behavior — **preserved**

## Christian — Member 4 Create/Edit Verification

### AI disclosure
Work was AI-assisted. AI was used to inspect the existing Week 6–8 Create/Edit implementation, identify the known Cancel-navigation gap, make focused Cancel-navigation changes, and assist with test planning/documentation. Existing CRUD behavior and resource-specific fields/routes were preserved.

### Implemented changes
- Updated Create/Edit Cancel navigation for Customer, Product, Order, and Delivery.
- Cancel actions now return to their corresponding resource list:
  - Customer → `/customers`
  - Product → `/products`
  - Order → `/orders`
  - Delivery → `/deliveries`
- Existing Create/Edit loading, success, validation, and control-restoration behavior was preserved.
- No Abdul detail-view files were modified for the Christian scope.

### Cancel navigation verification
All eight Create/Edit Cancel actions were manually verified in the local application:
- Customer Create → `/customers` — PASS
- Customer Edit → `/customers` — PASS
- Product Create → `/products` — PASS
- Product Edit → `/products` — PASS
- Order Create → `/orders` — PASS
- Order Edit → `/orders` — PASS
- Delivery Create → `/deliveries` — PASS
- Delivery Edit → `/deliveries` — PASS

## Jerfrans — Feedback-State Documentation and Testing

### AI disclosure
Work was AI-assisted. AI was used to assist with documenting and reviewing the feedback-state coverage for Deliverable 3.

### Implemented changes
- Updated `docs/feedback-matrix.md`.
- Updated `docs/feedback-tests.md`.
- Documented loading, validation, not-found, server-error, network-error, and navigation feedback states relevant to the implemented interface.
- Documented relationship-dropdown asynchronous states and detail-page navigation behavior.

### Testing notes
The updated feedback documentation records the applicable test coverage and identifies tests that had not been executed where applicable.

### AI-use classification
- Feedback documentation — **AI-assisted / AI-modified**
- Feedback-state review — **AI-assisted**
- Test execution claims — **not fabricated; documented according to the recorded testing status**

### Create/Edit testing

#### Customer
- Create successful submission — PASS; `201 Created`
- Create loading feedback (`Saving...`) — PASS
- Create success feedback and button restoration — PASS
- Create validation — PASS; `422`
- Edit existing data loaded — PASS
- Edit successful update — PASS; `200 OK`
- Edit loading feedback (`Updating...`) — PASS
- Edit success feedback and button restoration — PASS
- Edit validation — PASS; `422`

#### Product
- Create successful submission — PASS; `201 Created`
- Create validation — PASS; `422`
- Edit existing data loaded — PASS
- Edit successful update — PASS; `200 OK`
- Edit validation — PASS; `422`
- Loading, success feedback, and control restoration were verified during the successful Create/Edit tests.

#### Order
- Create successful submission — PASS; `201 Created`
- Create loading feedback (`Saving...`) — PASS
- Create success feedback and button restoration — PASS
- Create validation — PASS; `422`
- Edit existing data loaded — PASS
  - Customer ID: `1`
  - Product ID: `2`
  - Quantity: `10`
- Edit successful update from quantity `10` to `2` — PASS; `200 OK`
- Edit loading feedback (`Updating...`) — PASS
- Edit success feedback and button restoration — PASS
- Edit validation — PASS; `422`

#### Delivery
- Create successful submission — PASS; `201 Created`
- Create loading feedback (`Saving...`) — PASS
- Create success feedback and button restoration — PASS
- Create validation — PASS; `422`
- Edit existing data loaded — PASS
  - Customer ID: `1`
  - Delivery Date: `2026-10-13`
  - Status: `delivered`
- Edit successful update — PASS; `200 OK`
- Edit loading feedback (`Updating...`) — PASS
- Edit success feedback and button restoration — PASS
- Edit validation — PASS; `422`

### Validation notes
Browser-native HTML validation was temporarily disabled during selected 422 API tests using the form `noValidate` property so that invalid data could reach the backend. Browser validation was restored to `false` after testing.

### Scope limitations
No 500/server-failure or network-failure UI test is claimed for the Christian Create/Edit scope. These were not fabricated as successful tests.

### Evidence
Testing was performed against the local Laravel application at `http://127.0.0.1:8000`. Network responses and visible UI feedback were manually checked during the Create/Edit verification.

### Commit scope
Christian changes are limited to the Create/Edit Cancel-navigation fixes and the related Deliverable 3 AI documentation. No unrelated CRUD rewrite was performed.