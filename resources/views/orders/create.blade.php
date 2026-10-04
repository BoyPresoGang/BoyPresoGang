<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>

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

        input,
        select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            background: white;
        }

        input:focus,
        select:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
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
            opacity: 0.6;
            cursor: not-allowed;
        }

        .secondary-button {
            background: #6c757d;
        }

        .message {
            display: none;
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 6px;
        }

        .message.success {
            display: block;
            background: #d1e7dd;
            color: #0f5132;
        }

        .message.error {
            display: block;
            background: #f8d7da;
            color: #842029;
        }

        .field-error {
            display: none;
            margin-top: 6px;
            color: #b02a37;
            font-size: 14px;
        }

        .field-error.visible {
            display: block;
        }

        .input-error {
            border-color: #b02a37;
        }
    </style>
</head>

<body>
    <main class="container">

        <header class="header">
            <h1>Create Order</h1>
            <p class="description">
                Create a new customer order for water products.
            </p>
        </header>

        <section class="card" aria-label="Create order form">

            <div
                id="form-message"
                class="message"
                role="alert"
                aria-live="polite"
            ></div>

            <form id="order-form">

                <p class="form-note">
                    <span class="required">*</span> Required fields
                </p>

                <div class="form-group">
                    <label for="customer_id">
                        Customer <span class="required">*</span>
                    </label>

                    <select
                        id="customer_id"
                        name="customer_id"
                        required
                        aria-required="true"
                        aria-describedby="customer_id-error"
                    >
                        <option value="">Select a customer</option>
                        <option value="1">Juan Dela Cruz</option>
                        <option value="2">Maria Santos</option>
                    </select>

                    <div
                        id="customer_id-error"
                        class="field-error"
                        aria-live="polite"
                    ></div>
                </div>

                <div class="form-group">
                    <label for="product_id">
                        Product <span class="required">*</span>
                    </label>

                    <select
                        id="product_id"
                        name="product_id"
                        required
                        aria-required="true"
                        aria-describedby="product_id-error"
                    >
                        <option value="">Select a product</option>
                        <option value="1">5-Gallon Purified Water</option>
                        <option value="2">5-Gallon Mineral Water</option>
                    </select>

                    <div
                        id="product_id-error"
                        class="field-error"
                        aria-live="polite"
                    ></div>
                </div>

                <div class="form-group">
                    <label for="quantity">
                        Quantity <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="1"
                        step="1"
                        placeholder="Enter quantity"
                        required
                        aria-required="true"
                        aria-describedby="quantity-error"
                    >

                    <div
                        id="quantity-error"
                        class="field-error"
                        aria-live="polite"
                    ></div>
                </div>

                <div class="actions">
                    <button
                        type="submit"
                        id="submit-button"
                        class="button"
                    >
                        Save Order
                    </button>

                    <a href="/orders" class="button secondary-button">
                        Cancel
                    </a>
                </div>

            </form>

        </section>

    </main>

    <script>
        const orderForm = document.getElementById('order-form');
        const submitButton = document.getElementById('submit-button');
        const formMessage = document.getElementById('form-message');

        const fieldIds = [
            'customer_id',
            'product_id',
            'quantity'
        ];

        function clearMessages() {
            formMessage.className = 'message';
            formMessage.textContent = '';

            fieldIds.forEach(function (fieldId) {
                const field = document.getElementById(fieldId);
                const error = document.getElementById(fieldId + '-error');

                field.classList.remove('input-error');
                error.classList.remove('visible');
                error.textContent = '';
            });
        }

        function showMessage(type, message) {
            formMessage.className = 'message ' + type;
            formMessage.textContent = message;
        }

        function showFieldError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const error = document.getElementById(fieldId + '-error');

            if (!field || !error || !fieldIds.includes(fieldId)) {
                return false;
            }

            const label = document.querySelector('label[for="' + fieldId + '"]');
            const fieldName = label
                ? label.textContent.replace(/\s*\*$/, '').trim()
                : 'This field';
            const details = Array.isArray(message) ? message[0] : message;

            field.classList.add('input-error');
            error.textContent = fieldName + ': ' +
                (typeof details === 'string' && details.trim()
                    ? details
                    : 'Please enter a valid value.');
            error.classList.add('visible');
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

        orderForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            if (submitButton.disabled) {
                return;
            }

            clearMessages();

            submitButton.disabled = true;
            submitButton.textContent = 'Saving...';

            const data = {
                customer_id: Number(
                    document.getElementById('customer_id').value
                ),
                product_id: Number(
                    document.getElementById('product_id').value
                ),
                quantity: Number(
                    document.getElementById('quantity').value
                )
            };

            try {
                const response = await fetch('/api/orders', {
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
                        'Order created successfully.'
                    );

                    orderForm.reset();

                } else if (response.status === 422) {
                    const hasFieldErrors = showValidationErrors(result);
                    showMessage(
                        'error',
                        hasFieldErrors
                            ? 'Please correct the highlighted fields and try again.'
                            : 'Please review the order information and try again.'
                    );

                } else {
                    showMessage(
                        'error',
                        'Unable to create the order. Please try again later.'
                    );
                }

            } catch (error) {
                showMessage(
                    'error',
                    'Unable to reach the server. Please check your connection and try again.'
                );

            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Save Order';
            }
        });
    </script>

</body>
</html>
