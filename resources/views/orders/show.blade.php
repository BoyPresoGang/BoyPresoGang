<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background: #f8f9fa;
            color: #212529;
        }

        .container {
            max-width: 900px;
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

        .detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            padding: 14px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 600;
        }

        .actions {
            margin-top: 24px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            background: #212529;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 8px;
        }

        .secondary-button {
            background: #6c757d;
        }

        .state-message {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 32px;
            margin-bottom: 20px;
            text-align: center;
        }

        .state-message h2 {
            margin-top: 0;
        }

        .state-message p {
            color: #6c757d;
        }

        .error-state {
            border-color: #dc3545;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body>
    <main class="container">
        <header class="header">
            <h1>Order Details</h1>
            <p class="description">
                View the complete information for this customer order.
            </p>
        </header>

        <section class="state-message" data-state="not-found" aria-label="Order not found" hidden>
            <h2>Order not found</h2>
            <p>The requested order record was not found.</p>
            <a href="/orders" class="button secondary-button">Back to Orders</a>
        </section>

        <section class="state-message" data-state="loading" aria-label="Loading order details">
            <h2>Loading order details...</h2>
            <p>Please wait while the order information is being loaded.</p>
        </section>

        <section class="state-message error-state" data-state="error" aria-label="Order details error" hidden>
            <h2>Unable to load order</h2>
            <p data-error-message>The order information could not be loaded. Please try again.</p>
            <a href="#" class="button" data-retry="order">Try Again</a>
        </section>

        <section class="card" data-state="success" aria-label="Order details" hidden>
            <div class="detail-row">
                <span class="label">Order ID</span>
                <span id="order-id">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Customer ID</span>
                <span id="order-customer-id">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Product ID</span>
                <span id="order-product-id">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Quantity</span>
                <span id="order-quantity">-</span>
            </div>

            <div class="actions">
                <a href="/orders" id="order-edit-link" class="button">Edit Order</a>
                <a href="/orders" class="button secondary-button">Back to Orders</a>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const endpoint = '/api/orders';
            const stateSections = {
                loading: document.querySelector('[data-state="loading"]'),
                error: document.querySelector('[data-state="error"]'),
                notFound: document.querySelector('[data-state="not-found"]'),
                success: document.querySelector('[data-state="success"]'),
            };
            const fields = {
                id: document.getElementById('order-id'),
                customer_id: document.getElementById('order-customer-id'),
                product_id: document.getElementById('order-product-id'),
                quantity: document.getElementById('order-quantity'),
            };
            const errorMessage = document.querySelector('[data-error-message]');
            const editLink = document.getElementById('order-edit-link');

            function setState(stateName) {
                Object.keys(stateSections).forEach(function (key) {
                    if (stateSections[key]) {
                        stateSections[key].hidden = key !== stateName;
                    }
                });
            }

            function showError(message) {
                errorMessage.textContent = message;
                setState('error');
            }

            function getRecordId() {
                const parts = window.location.pathname.split('/').filter(Boolean);
                return parts.length ? parts[parts.length - 1] : '';
            }

            function renderOrder(record) {
                fields.id.textContent = record && record.id !== undefined && record.id !== null ? record.id : 'N/A';
                fields.customer_id.textContent = record && record.customer_id !== undefined && record.customer_id !== null ? record.customer_id : 'N/A';
                fields.product_id.textContent = record && record.product_id !== undefined && record.product_id !== null ? record.product_id : 'N/A';
                fields.quantity.textContent = record && record.quantity !== undefined && record.quantity !== null ? record.quantity : 'N/A';
            }

            async function loadOrder() {
                const id = getRecordId();
                setState('loading');

                if (!id) {
                    setState('notFound');
                    return;
                }

                if (editLink) {
                    editLink.href = '/orders/edit/' + encodeURIComponent(id);
                }

                let response;
                try {
                    response = await fetch(endpoint + '/' + encodeURIComponent(id));
                } catch (error) {
                    showError("We couldn't connect to the server. Check your connection and try again.");
                    return;
                }

                if (response.status === 404) {
                    setState('notFound');
                    return;
                }

                if (!response.ok) {
                    showError(response.status >= 500
                        ? "The server is having trouble loading this order's information. Please try again."
                        : "We couldn't load this order's information. Please try again.");
                    return;
                }

                let payload;
                try {
                    payload = await response.json();
                } catch (error) {
                    showError("The server returned an unexpected response. Please try again.");
                    return;
                }

                if (!payload || typeof payload !== 'object' || payload.status !== 200
                    || !payload.data || typeof payload.data !== 'object' || Array.isArray(payload.data)) {
                    showError("The server returned an unexpected response. Please try again.");
                    return;
                }

                renderOrder(payload.data);
                setState('success');
            }

            const retryLink = document.querySelector('[data-retry="order"]');
            if (retryLink) {
                retryLink.addEventListener('click', function (event) {
                    event.preventDefault();
                    loadOrder();
                });
            }

            loadOrder();
        });
    </script>
</body>
</html>
