<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>

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
            <h1>Edit Order</h1>
            <p class="description">
                Update the customer order information.
            </p>
        </header>

        <section class="card" aria-label="Edit order form">

            <form id="order-edit-form">

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
                    >

                    <p id="customer_id-error" class="field-error"></p>
                </div>

                <div class="form-group">
                    <label for="product_id">
                        Product ID <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        id="product_id"
                        name="product_id"
                        min="1"
                        required
                        aria-required="true"
                    >

                    <p id="product_id-error" class="field-error"></p>
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
                        required
                        aria-required="true"
                    >

                    <p id="quantity-error" class="field-error"></p>
                </div>

                <p id="form-error" class="form-error"></p>
                <p id="form-success" class="form-success"></p>

                <div class="actions">
                    <button
                        id="submit-button"
                        type="submit"
                    >
                        Update Order
                    </button>

                    <a href="#" class="button secondary-button">
                        Cancel
                    </a>
                </div>

            </form>

        </section>

    </main>

    <script>
        const orderForm = document.getElementById('order-edit-form');
        const orderSubmitButton = document.getElementById('submit-button');

        const orderId =
            new URLSearchParams(window.location.search).get('id') || 1;

        async function loadOrder() {
            try {
                const response = await fetch(`/api/orders/${orderId}`);

                if (!response.ok) {
                    throw new Error('Unable to load order.');
                }

                const result = await response.json();

                document.getElementById('customer_id').value =
                    result.data.customer_id ?? '';

                document.getElementById('product_id').value =
                    result.data.product_id ?? '';

                document.getElementById('quantity').value =
                    result.data.quantity ?? '';
            } catch (error) {
                document.getElementById('form-error').textContent =
                    'Unable to load the order. Please try again.';
            }
        }

        orderForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            orderSubmitButton.disabled = true;
            orderSubmitButton.textContent = 'Updating...';

            document.getElementById('form-error').textContent = '';
            document.getElementById('form-success').textContent = '';

            document.getElementById('customer_id-error').textContent = '';
            document.getElementById('product_id-error').textContent = '';
            document.getElementById('quantity-error').textContent = '';

            const data = {
                customer_id:
                    document.getElementById('customer_id').value,

                product_id:
                    document.getElementById('product_id').value,

                quantity:
                    document.getElementById('quantity').value
            };

            try {
                const response = await fetch(`/api/orders/${orderId}`, {
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
                        'Order updated successfully.';
                } else if (response.status === 422) {
                    if (result.errors) {
                        Object.entries(result.errors).forEach(
                            ([field, messages]) => {
                                const errorElement =
                                    document.getElementById(
                                        `${field}-error`
                                    );

                                if (errorElement) {
                                    errorElement.textContent =
                                        Array.isArray(messages)
                                            ? messages[0]
                                            : messages;
                                }
                            }
                        );
                    } else {
                        document.getElementById('form-error').textContent =
                            'Please check the form for errors.';
                    }
                } else {
                    document.getElementById('form-error').textContent =
                        'Unable to update the order. Please try again.';
                }
            } catch (error) {
                document.getElementById('form-error').textContent =
                    'A network error occurred. Please try again.';
            } finally {
                orderSubmitButton.disabled = false;
                orderSubmitButton.textContent = 'Update Order';
            }
        });

        loadOrder();
    </script>
</body>
</html>