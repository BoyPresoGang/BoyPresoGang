# Week 5 Test Strategy & Pipeline Verification

## Standardized Envelope Verification
All success responses adhere to:

json
{
"status": 200,
"data": { ...record... }
}

All error responses adhere to:

json
{
"status": 422,
"error": "Error message",
"field": "field_name"
}

## Global Test Suite Execution
Run all tests locally before opening a PR:

bash
php artisan test

### Coverage Breakdown
- **Customers:** Happy Path, Validation Error, 404 Edge Case
- **Products:** Happy Path, String Price Type Mismatch, Negative Stock Edge Case
- **Orders:** Happy Path, Zero Quantity, Missing Customer ID Edge Case
- **Deliveries:** Happy Path, Invalid Status Enum, Malformed Date Edge Case