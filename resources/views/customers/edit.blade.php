@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container container-medium">
    <header class="header">
        <div>
            <h1>Edit Customer</h1>
            <p class="description">Update the customer information.</p>
        </div>
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
                    inputmode="numeric"
                    pattern="[0-9]{11}"
                    minlength="11"
                    maxlength="11"
                    autocomplete="tel"
                    aria-describedby="contact_number-error"
                >
                <p id="contact_number-error" class="field-error" role="alert"></p>
            </div>

            <p id="form-error" class="field-error" role="alert"></p>
            <p id="form-success" class="form-message success" role="status" style="display:none;"></p>

            <div class="actions" style="margin-top: 24px;">
                <button id="submit-button" type="submit" class="button">
                    Update Customer
                </button>
                <a href="/customers" class="button secondary">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>

<script>
const customerForm =
    document.getElementById('customer-edit-form');

const customerSubmitButton =
    document.getElementById('submit-button');

const customerId =
    window.location.pathname.split('/').filter(Boolean).pop() || '';

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

    const formError = document.getElementById('form-error');
    const formSuccess = document.getElementById('form-success');
    formError.textContent = '';
    formSuccess.textContent = '';
    formSuccess.style.display = 'none';

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
            formSuccess.textContent = 'Customer updated successfully.';
            formSuccess.style.display = 'block';
        } else if (response.status === 422) {
            const hasFieldErrors =
                showCustomerValidationErrors(result);

            formError.textContent =
                hasFieldErrors
                    ? 'Please correct the highlighted fields and try again.'
                    : 'Please review the customer information and try again.';
        } else {
            formError.textContent =
                'Unable to update the customer. Please try again later.';
        }

    } catch (error) {
        formError.textContent =
            'Unable to reach the server. Please check your connection and try again.';
    } finally {
        customerSubmitButton.disabled = false;
        customerSubmitButton.textContent = 'Update Customer';
    }
});

loadCustomer();
</script>
@endsection