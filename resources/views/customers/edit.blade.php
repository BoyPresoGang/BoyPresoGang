<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>

    <style>
        .page {
            max-width: 800px;
            margin: 0 auto;
            padding: 24px;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0;
        }

        .description {
            color: #6c757d;
            margin-top: 6px;
        }

        .card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-group input:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }

        button,
        .button {
            display: inline-block;
            padding: 10px 16px;
            background: #212529;
            color: white;
            border: none;
            text-decoration: none;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 8px;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .secondary {
            background: #6c757d;
        }

        .field-error,
        .form-error {
            color: #b02a37;
            margin: 6px 0 0;
        }

        .form-success {
            color: #146c43;
            margin: 6px 0 12px;
        }
    </style>
</head>

<body>

<div class="page">

    <header class="page-header">
        <h1>Edit Customer</h1>
        <p class="description">
            Update the customer information.
        </p>
    </header>

    <section class="card">

        <form id="customer-edit-form">

            <div class="form-group">
                <label for="name">
                    Customer Name <span aria-hidden="true">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    minlength="2"
                    maxlength="100"
                    autocomplete="name"
                    aria-describedby="name-error"
                >

                <p id="name-error" class="field-error" role="alert"></p>
            </div>

            <div class="form-group">
                <label for="contact_number">
                    Contact Number <span aria-hidden="true">*</span>
                </label>

                <input
                    type="text"
                    id="contact_number"
                    name="contact_number"
                    required
                    minlength="7"
                    maxlength="20"
                    autocomplete="tel"
                    aria-describedby="contact_number-error"
                >

                <p
                    id="contact_number-error"
                    class="field-error"
                    role="alert"
                ></p>
            </div>

            <p id="form-error" class="form-error" role="alert"></p>

            <p id="form-success" class="form-success" role="status"></p>

            <button id="submit-button" type="submit">
                Update Customer
            </button>

            <a href="#" class="button secondary">
                Cancel
            </a>

        </form>

    </section>

</div>

<script>
const customerForm =
    document.getElementById('customer-edit-form');

const customerSubmitButton =
    document.getElementById('submit-button');

const customerId =
    new URLSearchParams(window.location.search).get('id') || 1;

const customerFieldIds = ['name', 'contact_number'];

function clearCustomerFieldErrors() {
    customerFieldIds.forEach((fieldId) => {
        document.getElementById(fieldId).removeAttribute('aria-invalid');
        document.getElementById(`${fieldId}-error`).textContent = '';
    });
}

function showCustomerFieldError(fieldId, message) {
    if (!customerFieldIds.includes(fieldId)) {
        return false;
    }

    const label = document.querySelector(`label[for="${fieldId}"]`);
    const fieldName = label
        ? label.textContent.replace(/\s*\*$/, '').trim()
        : 'This field';
    const details = Array.isArray(message) ? message[0] : message;

    document.getElementById(fieldId).setAttribute('aria-invalid', 'true');
    document.getElementById(`${fieldId}-error`).textContent =
        `${fieldName}: ${
            typeof details === 'string' && details.trim()
                ? details
                : 'Please enter a valid value.'
        }`;
    return true;
}

function showCustomerValidationErrors(result) {
    let hasFieldErrors = false;

    if (result && typeof result.field === 'string') {
        hasFieldErrors = showCustomerFieldError(
            result.field,
            result.error
        ) || hasFieldErrors;
    }

    if (result && result.errors &&
        typeof result.errors === 'object' &&
        !Array.isArray(result.errors)) {
        Object.entries(result.errors).forEach(([fieldId, message]) => {
            hasFieldErrors = showCustomerFieldError(
                fieldId,
                message
            ) || hasFieldErrors;
        });
    }

    return hasFieldErrors;
}

async function loadCustomer() {

    try {

        const response =
            await fetch(`/api/customers/${customerId}`);

        if (!response.ok) {
            throw new Error('Unable to load customer.');
        }

        const result =
            await response.json();

        document.getElementById('name').value =
            result.data.name ?? '';

        document.getElementById('contact_number').value =
            result.data.contact_number ?? '';

    } catch (error) {

        document.getElementById('form-error').textContent =
            'Unable to load the customer. Please try again.';
    }
}


customerForm.addEventListener('submit', async (event) => {

    event.preventDefault();

    if (customerSubmitButton.disabled) {
        return;
    }

    customerSubmitButton.disabled = true;
    customerSubmitButton.textContent = 'Updating...';

    document.getElementById('form-error').textContent = '';
    document.getElementById('form-success').textContent = '';

    clearCustomerFieldErrors();


    const data = {

        name: document.getElementById('name').value,

        contact_number:
            document.getElementById('contact_number').value

    };


    try {

        const response = await fetch(
            `/api/customers/${customerId}`,
            {
                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify(data)
            }
        );


        const result =
            await response.json();


        if (response.status === 200) {

            document.getElementById('form-success').textContent =
                'Customer updated successfully.';

        } else if (response.status === 422) {

            const hasFieldErrors =
                showCustomerValidationErrors(result);

            document.getElementById('form-error').textContent =
                hasFieldErrors
                    ? 'Please correct the highlighted fields and try again.'
                    : 'Please review the customer information and try again.';

        } else {

            document.getElementById('form-error').textContent =
                'Unable to update the customer. Please try again later.';
        }

    } catch (error) {

        document.getElementById('form-error').textContent =
            'Unable to reach the server. Please check your connection and try again.';

    } finally {

        customerSubmitButton.disabled = false;
        customerSubmitButton.textContent = 'Update Customer';
    }

});


loadCustomer();
</script>

</body>
</html>