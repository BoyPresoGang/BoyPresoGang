# Validation Matrix

| Route | Field | Rules |
| :--- | :--- | :--- |
| POST /customers | name | required, string, 2-100 chars |
| POST /customers | contact_number | required, string, 7-20 chars, unique |
| PUT /customers | name | sometimes, string, 2-100 chars |
| PUT /customers | contact_number | sometimes, string, 7-20 chars, unique |
| POST /products | name | required, string, 2-150 chars |
| POST /products | price | required, number, greater than 0 |
| POST /products | stock | required, integer, 0 or greater |
| PUT /products | name | sometimes, string, 2-150 chars |
| PUT /products | price | sometimes, number, greater than 0 |
| PUT /products | stock | sometimes, integer, 0 or greater |