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
                {{-- Empty State --}}
        <section class="state-message" aria-label="Delivery not found">
            <h2>Delivery not found</h2>
            <p>The requested delivery record does not exist.</p>
            <a href="#" class="button secondary-button">Back to Deliveries</a>
        </section>

        {{-- Loading State --}}
        <section class="state-message" aria-label="Loading delivery details">
            <h2>Loading delivery details...</h2>
            <p>Please wait while the delivery information is being loaded.</p>
        </section>

        {{-- Error State --}}
        <section class="state-message error-state" aria-label="Delivery details error">
            <h2>Unable to load delivery</h2>
            <p>Something went wrong while loading this delivery's information.</p>
            <a href="#" class="button">Try Again</a>
        </section>

        {{-- Normal Delivery Details --}}
        
        <section class="card" aria-label="Delivery details">

            <div class="detail-row">
                <span class="label">Delivery ID</span>
                <span>1</span>
            </div>

            <div class="detail-row">
                <span class="label">Order</span>
                <span>#1001</span>
            </div>

            <div class="detail-row">
                <span class="label">Customer</span>
                <span>Juan Dela Cruz</span>
            </div>

            <div class="detail-row">
                <span class="label">Delivery Address</span>
                <span>Maramag, Bukidnon</span>
            </div>

            <div class="detail-row">
                <span class="label">Status</span>
                <span>Pending</span>
            </div>

            <div class="actions">
                <a href="#" class="button">Edit Delivery</a>
                <a href="#" class="button secondary-button">Back to Deliveries</a>
            </div>

        </section>

    </main>
</body>
</html>