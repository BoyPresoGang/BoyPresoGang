@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
<div class="container container-narrow">
    <header class="header">
        <div>
            <h1>Create Customer</h1>
            <p class="description">Add a new customer to the water refilling station.</p>
        </div>
    </header>

    <section class="card" aria-label="Create customer form">
        <div id="form-message" class="form-message" role="alert" aria-live="polite"></div>

        <form id="customer-form" action="#" method="POST">
            <p class="form-note">
                <span class="required">*</span> Required fields
            </p>

            <div class="form-group">
                <label for="name">
                    Customer Name <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter customer name"
                    autocomplete="name"
                    minlength="2"
                    maxlength="100"
                    required
                    aria-required="true"
                    aria-describedby="name-error"
                >
                <span id="name-error" class="field-error" aria-live="polite"></span>
            </div>

            <div class="form-group">
                <label for="contact_number">
                    Contact Number <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="contact_number"
                    name="contact_number"
                    placeholder="Enter contact number"
                    autocomplete="tel"
                    inputmode="numeric"
                    pattern="[0-9]{11}"
                    minlength="11"
                    maxlength="11"
                    required
                    aria-required="true"
                    aria-describedby="contact_number-error"
                >
                <span id="contact_number-error" class="field-error" aria-live="polite"></span>
            </div>

            <div class="actions" style="margin-top: 24px;">
                <button type="submit" id="submit-button" class="button">
                    Save Customer
                </button>
                <a href="/customers" class="button secondary-button">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>

<script>
    const customerForm = document.getElementById('customer-form');
    const submitButton = document.getElementById('submit-button');
    const formMessage = document.getElementById('form-message');

    const fieldIds = [
        'name',
        'contact_number'
    ];

    function clearMessages() {
        formMessage.textContent = '';
        formMessage.className = 'form-message';

        fieldIds.forEach(function (fieldId) {
            const input = document.getElementById(fieldId);
            const error = document.getElementById(fieldId + '-error');

            input.removeAttribute('aria-invalid');
            error.textContent = '';
        });
    }

    function showMessage(type, message) {
        formMessage.textContent = message;
        formMessage.className = 'form-message ' + type;
    }

    function showFieldError(fieldId, message) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + '-error');

        if (!input || !error || !fieldIds.includes(fieldId)) {
            return false;
        }

        const label = document.querySelector('label[for="' + fieldId + '"]');
        const fieldName = label
            ? label.textContent.replace(/\s*\*$/, '').trim()
            : 'This field';
        const details = Array.isArray(message) ? message[0] : message;

        input.setAttribute('aria-invalid', 'true');
        error.textContent = fieldName + ': ' +
            (typeof details === 'string' && details.trim()
                ? details
                : 'Please enter a valid value.');
        return true;
    }

    function showValidationErrors(result) {
        let hasFieldErrors = false;

        if (result && typeof result.field === 'string') {
            hasFieldErrors = showFieldError(
                result.field,
                result.error
            ) || hasFieldErrors;
        }

        if (result && result.errors &&
            typeof result.errors === 'object' &&
            !Array.isArray(result.errors)) {
            Object.entries(result.errors).forEach(function (entry) {
                hasFieldErrors = showFieldError(
                    entry[0],
                    entry[1]
                ) || hasFieldErrors;
            });
        }

        return hasFieldErrors;
    }

    function handleInvalidInput(event) {
        const input = event.target;

        if (!input || !fieldIds.includes(input.id)) {
            return;
        }

        if (input === customerForm.querySelector(':invalid')) {
            clearMessages();
        }

        let message = 'Please enter a valid value.';

        if (input.validity.valueMissing) {
            message = 'Please enter a value.';
        } else if (input.id === 'contact_number' && (
            input.validity.patternMismatch ||
            input.validity.tooShort ||
            input.validity.tooLong
        )) {
            message = 'Please enter an 11-digit number.';
        }

        showFieldError(input.id, message);
        showMessage(
            'error',
            'Please correct the highlighted fields and try again.'
        );
    }

    customerForm.addEventListener('invalid', handleInvalidInput, true);

    customerForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        if (submitButton.disabled) {
            return;
        }

        clearMessages();

        submitButton.disabled = true;
        submitButton.textContent = 'Saving...';

        const data = {
            name: document.getElementById('name').value.trim(),
            contact_number: document
                .getElementById('contact_number')
                .value.trim()
        };

        try {
            const response = await fetch('/api/customers', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.status === 201) {
                showMessage(
                    'success',
                    'Customer created successfully.'
                );

                customerForm.reset();
            } else if (response.status === 422) {
                const hasFieldErrors = showValidationErrors(result);
                showMessage(
                    'error',
                    hasFieldErrors
                        ? 'Please correct the highlighted fields and try again.'
                        : 'Please review the customer information and try again.'
                );
            } else {
                showMessage(
                    'error',
                    'Unable to create the customer. Please try again later.'
                );
            }
        } catch (error) {
            showMessage(
                'error',
                'Unable to reach the server. Please check your connection and try again.'
            );
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Save Customer';
        }
    });
</script>
@endsection
