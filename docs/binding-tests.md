\# Week 7 Binding Tests



\## Purpose



This document records the end-to-end binding tests for the Week 7 Create and Update forms.



The Week 7 requirements are to verify that:

\- Create operations persist successfully.

\- Update operations persist successfully.

\- Invalid data returns a `422` validation response.



\## Create Form Tests



\### Customer Create



| Test | Input | Expected Result | Actual Result | Status |

|---|---|---|---|---|

| Create valid customer | Name: Juan Dela Cruz; Contact: 09123456789 | Customer is created and persisted | Customer created successfully and form cleared | PASS |



\### Product Create



| Test | Input | Expected Result | Actual Result | Status |

|---|---|---|---|---|

| Create valid product | Name: 5-Gallon Purified Water; Price: 25; Stock: 10 | Product is created and persisted | Product created successfully and form cleared | PASS |

| Invalid price | Price: 0 | API returns HTTP 422 | HTTP 422 returned with `price` validation error | PASS |



\### Order Create



| Test | Input | Expected Result | Actual Result | Status |

|---|---|---|---|---|

| Create valid order | Customer: 1; Product: 1; Quantity: valid quantity | Order is created and persisted | Order created successfully | PASS |

| Invalid quantity | Quantity: 0 | API returns HTTP 422 | HTTP 422 returned with `quantity` validation error | PASS |



\### Delivery Create



| Test | Input | Expected Result | Actual Result | Status |

|---|---|---|---|---|

| Create valid delivery | Customer: 1; Valid delivery date; Status: Scheduled | Delivery is created and persisted | Delivery created successfully | PASS |

| Invalid delivery date | Delivery date: `not-a-date` | API returns HTTP 422 | HTTP 422 returned with `delivery\_date` validation error | PASS |



\## Update Form Tests



Update tests will be completed after the Customer/Product and Order/Delivery Update forms are implemented and merged from the Week 7 Update tasks.



| Test | Status |

|---|---|

| Customer Update persists | PENDING |

| Product Update persists | PENDING |

| Order Update persists | PENDING |

| Delivery Update persists | PENDING |

| Invalid Customer Update returns 422 | PENDING |

| Invalid Product Update returns 422 | PENDING |

| Invalid Order Update returns 422 | PENDING |

| Invalid Delivery Update returns 422 | PENDING |



\## Notes



The Create form tests were performed against the Week 7 API endpoints and browser forms.



Validation responses were verified using HTTP requests and confirmed to return HTTP `422` with the affected field and validation message.



Update tests remain pending until the corresponding Week 7 Update forms are completed and merged.

