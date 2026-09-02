# Validation Matrix

| Route | Field | Rules |
| :--- | :--- | :--- |
| POST /customers | name | required, string, 2-100 chars |
| POST /customers | contact_number | required, string, 7-20 chars, unique |
| PUT /customers | name | sometimes, string, 2-100 chars |
| PUT /customers | contact_number | sometimes, string, 7-20 chars, unique |