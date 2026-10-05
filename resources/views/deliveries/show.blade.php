<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Details</title>

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
            <h1>Delivery Details</h1>
            <p class="description">
                View the complete information for this delivery.
            </p>
        </header>

        <section class="state-message" data-state="not-found" aria-label="Delivery not found" hidden>
            <h2>Delivery not found</h2>
            <p>The requested delivery record was not found.</p>
            <a href="/deliveries" class="button secondary-button">Back to Deliveries</a>
        </section>

        <section class="state-message" data-state="loading" aria-label="Loading delivery details">
            <h2>Loading delivery details...</h2>
            <p>Please wait while the delivery information is being loaded.</p>
        </section>

        <section class="state-message error-state" data-state="error" aria-label="Delivery details error" hidden>
            <h2>Unable to load delivery</h2>
            <p data-error-message>The delivery information could not be loaded. Please try again.</p>
            <a href="#" class="button" data-retry="delivery">Try Again</a>
        </section>

        <section class="card" data-state="success" aria-label="Delivery details" hidden>
            <div class="detail-row">
                <span class="label">Delivery ID</span>
                <span id="delivery-id">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Customer ID</span>
                <span id="delivery-customer-id">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Delivery Date</span>
                <span id="delivery-date">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Status</span>
                <span id="delivery-status">-</span>
            </div>

            <div class="actions">
                <a href="/deliveries" id="delivery-edit-link" class="button">Edit Delivery</a>
                <a href="/deliveries" class="button secondary-button">Back to Deliveries</a>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const endpoint = '/api/deliveries';
            const stateSections = {
                loading: document.querySelector('[data-state="loading"]'),
                error: document.querySelector('[data-state="error"]'),
                notFound: document.querySelector('[data-state="not-found"]'),
                success: document.querySelector('[data-state="success"]'),
            };
            const fields = {
                id: document.getElementById('delivery-id'),
                customer_id: document.getElementById('delivery-customer-id'),
                delivery_date: document.getElementById('delivery-date'),
                status: document.getElementById('delivery-status'),
            };
            const errorMessage = document.querySelector('[data-error-message]');
            const editLink = document.getElementById('delivery-edit-link');

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

            function renderDelivery(record) {
                fields.id.textContent = record && record.id !== undefined && record.id !== null ? record.id : 'N/A';
                fields.customer_id.textContent = record && record.customer_id !== undefined && record.customer_id !== null ? record.customer_id : 'N/A';
                fields.delivery_date.textContent = record && record.delivery_date ? record.delivery_date : 'N/A';
                fields.status.textContent = record && record.status ? record.status : 'N/A';
            }

            async function loadDelivery() {
                const id = getRecordId();
                setState('loading');

                if (!id) {
                    setState('notFound');
                    return;
                }

                if (editLink) {
                    editLink.href = '/deliveries/edit/' + encodeURIComponent(id);
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
                        ? "The server is having trouble loading this delivery's information. Please try again."
                        : "We couldn't load this delivery's information. Please try again.");
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

                renderDelivery(payload.data);
                setState('success');
            }

            const retryLink = document.querySelector('[data-retry="delivery"]');
            if (retryLink) {
                retryLink.addEventListener('click', function (event) {
                    event.preventDefault();
                    loadDelivery();
                });
            }

            loadDelivery();
        });
    </script>
</body>
</html>
