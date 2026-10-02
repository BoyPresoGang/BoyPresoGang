<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background: #f8f9fa;
            color: #212529;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 24px;
        }

        h1 {
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

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .required {
            color: #b02a37;
        }

        .form-note {
            margin-bottom: 20px;
            color: #6c757d;
            font-size: 14px;
        }

        .field-error {
            display: block;
            margin-top: 6px;
            color: #b02a37;
            font-size: 14px;
        }

        .form-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 6px;
            display: none;
        }

        .form-message.success {
            display: block;
            background: #d1e7dd;
            color: #0f5132;
        }

        .form-message.error {
            display: block;
            background: #f8d7da;
            color: #842029;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
        }

        input:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }

        input[aria-invalid="true"] {
            border-color: #b02a37;
        }

        .actions {
            margin-top: 24px;
        }

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

        .button:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            outline-offset: 2px;
        }

        .button:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .secondary-button {
            background: #6c757d;
        }
    </style>
</head>

<body>
    <main class="container">

        <header class="header">
            <h1>Create Customer</h1>
            <p class="description">
                Add a new customer to the water refilling station.
            </p>
        </header>

        <section class="card" aria-label="Create customer form">

            <div
                id="form-message"
                class="form-message"
                role="alert"
                aria-live="polite"
            ></div>

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

                    <span
                        id="name-error"
                        class="field-error"
                        aria-live="polite"
                    ></span>
                </div>

                <div class="form-group">
                    <label for="contact_number">
                        Contact Number <span class="required">*</span>
                    </label>

                    <input
                        type="tel"
                        id="contact_number"
                        name="contact_number"
                        placeholder="Enter contact number"
                        autocomplete="tel"
                        minlength="7"
                        maxlength="20"
                        required
                        aria-required="true"
                        aria-describedby="contact_number-error"
                    >

                    <span
                        id="contact_number-error"
                        class="field-error"
                        aria-live="polite"
                    ></span>
                </div>

                <div class="actions">
                    <button
                        type="submit"
                        id="submit-button"
                        class="button"
                    >
                        Save Customer
                    </button>

                    <a href="#" class="button secondary-button">
                        Cancel
                    </a>
                </div>

            </form>

        </section>

    </main>

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

            if (!input || !error) {
                return;
            }

            input.setAttribute('aria-invalid', 'true');
            error.textContent = message;
        }

        customerForm.addEventListener('submit', async function (event) {
            event.preventDefault();

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
                    showMessage(
                        'error',
                        'Please correct the highlighted field.'
                    );

                    if (result.field && result.error) {
                        showFieldError(result.field, result.error);
                    }
                } else {
                    showMessage(
                        'error',
                        'Unable to create the customer. Please try again.'
                    );
                }
            } catch (error) {
                showMessage(
                    'error',
                    'A network error occurred. Please check your connection and try again.'
                );
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Save Customer';
            }
        });
    </script>
</body>
</html>