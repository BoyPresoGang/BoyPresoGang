<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Delivery</title>

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

        .form-group input,
        .form-group select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }

        .field-error {
            color: #b02a37;
            font-size: 14px;
            margin-top: 6px;
        }

        .form-error {
            color: #b02a37;
            margin-top: 16px;
        }

        .form-success {
            color: #146c43;
            margin-top: 16px;
        }

        .actions {
            margin-top: 24px;
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

        .button:focus,
        button:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            outline-offset: 2px;
        }

        .secondary-button {
            background: #6c757d;
        }
    </style>
</head>

<body>
    <main class="container">

        <header class="header">
            <h1>Edit Delivery</h1>
            <p class="description">
                Update the delivery information and status.
            </p>
        </header>

        <section class="card" aria-label="Edit delivery form">

            <form id="delivery-edit-form">

                <p class="form-note">
                    <span class="required">*</span> Required fields
                </p>

                <div class="form-group">
                    <label for="customer_id">
                        Customer ID <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        id="customer_id"
                        name="customer_id"
                        min="1"
                        required
                        aria-required="true"
                        aria-describedby="customer_id-error"
                    >

                    <p id="customer_id-error" class="field-error" role="alert"></p>
                </div>

                <div class="form-group">
                    <label for="delivery_date">
                        Delivery Date <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        id="delivery_date"
                        name="delivery_date"
                        required
                        aria-required="true"
                        aria-describedby="delivery_date-error"
                    >

                    <p id="delivery_date-error" class="field-error" role="alert"></p>
                </div>

                <div class="form-group">
                    <label for="status">
                        Status <span class="required">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        aria-required="true"
                        aria-describedby="status-error"
                    >
                        <option value="scheduled">Scheduled</option>
                        <option value="in_transit">In Transit</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>

                    <p id="status-error" class="field-error" role="alert"></p>
                </div>

                <p id="form-error" class="form-error"></p>
                <p id="form-success" class="form-success"></p>

                <div class="actions">
                    <button
                        id="submit-button"
                        type="submit"
                    >
                        Update Delivery
                    </button>

                    <a href="#" class="button secondary-button">
                        Cancel
                    </a>
                </div>

            </form>

        </section>

    </main>

    <script>
        const deliveryForm =
            document.getElementById('delivery-edit-form');

        const deliverySubmitButton =
            document.getElementById('submit-button');

        const deliveryId =
            new URLSearchParams(window.location.search).get('id') || 1;

        const deliveryFieldIds = [
            'customer_id',
            'delivery_date',
            'status'
        ];

        function clearDeliveryFieldErrors() {
            deliveryFieldIds.forEach((fieldId) => {
                document.getElementById(fieldId)
                    .removeAttribute('aria-invalid');
                document.getElementById(`${fieldId}-error`).textContent = '';
            });
        }

        function showDeliveryFieldError(fieldId, message) {
            if (!deliveryFieldIds.includes(fieldId)) {
                return false;
            }

            const label = document.querySelector(`label[for="${fieldId}"]`);
            const fieldName = label
                ? label.textContent.replace(/\s*\*$/, '').trim()
                : 'This field';
            const details = Array.isArray(message) ? message[0] : message;

            document.getElementById(fieldId)
                .setAttribute('aria-invalid', 'true');
            document.getElementById(`${fieldId}-error`).textContent =
                `${fieldName}: ${
                    typeof details === 'string' && details.trim()
                        ? details
                        : 'Please enter a valid value.'
                }`;
            return true;
        }

        function showDeliveryValidationErrors(result) {
            let hasFieldErrors = false;

            if (result && typeof result.field === 'string') {
                hasFieldErrors = showDeliveryFieldError(
                    result.field,
                    result.error
                ) || hasFieldErrors;
            }

            if (result && result.errors &&
                typeof result.errors === 'object' &&
                !Array.isArray(result.errors)) {
                Object.entries(result.errors).forEach(
                    ([fieldId, message]) => {
                        hasFieldErrors = showDeliveryFieldError(
                            fieldId,
                            message
                        ) || hasFieldErrors;
                    }
                );
            }

            return hasFieldErrors;
        }

        async function loadDelivery() {
            try {
                const response =
                    await fetch(`/api/deliveries/${deliveryId}`);

                if (!response.ok) {
                    throw new Error('Unable to load delivery.');
                }

                const result = await response.json();

                document.getElementById('customer_id').value =
                    result.data.customer_id ?? '';

                document.getElementById('delivery_date').value =
                    result.data.delivery_date ?? '';

                document.getElementById('status').value =
                    result.data.status ?? 'scheduled';

            } catch (error) {
                document.getElementById('form-error').textContent =
                    'Unable to load the delivery. Please try again.';
            }
        }

        deliveryForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (deliverySubmitButton.disabled) {
                return;
            }

            deliverySubmitButton.disabled = true;
            deliverySubmitButton.textContent = 'Updating...';

            document.getElementById('form-error').textContent = '';
            document.getElementById('form-success').textContent = '';

            clearDeliveryFieldErrors();

            const data = {
                customer_id:
                    document.getElementById('customer_id').value,

                delivery_date:
                    document.getElementById('delivery_date').value,

                status:
                    document.getElementById('status').value
            };

            try {
                const response =
                    await fetch(`/api/deliveries/${deliveryId}`, {
                        method: 'PUT',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },

                        body: JSON.stringify(data)
                    });

                const result = await response.json();

                if (response.status === 200) {
                    document.getElementById('form-success').textContent =
                        'Delivery updated successfully.';

                } else if (response.status === 422) {
                    const hasFieldErrors =
                        showDeliveryValidationErrors(result);
                    document.getElementById('form-error').textContent =
                        hasFieldErrors
                            ? 'Please correct the highlighted fields and try again.'
                            : 'Please review the delivery information and try again.';

                } else {
                    document.getElementById('form-error').textContent =
                        'Unable to update the delivery. Please try again later.';

                }

            } catch (error) {
                document.getElementById('form-error').textContent =
                    'Unable to reach the server. Please check your connection and try again.';

            } finally {
                deliverySubmitButton.disabled = false;
                deliverySubmitButton.textContent = 'Update Delivery';
            }
        });

        loadDelivery();
    </script>
</body>
</html>