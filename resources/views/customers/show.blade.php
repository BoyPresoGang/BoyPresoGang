<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>

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
    </style>
</head>

<body>
    <main class="container">

        <header class="header">
            <h1>Customer Details</h1>
            <p class="description">
                View the complete information for this customer.
            </p>
        </header>

        <section class="card" aria-label="Customer details">

            <div class="detail-row">
                <span class="label">Customer ID</span>
                <span>1</span>
            </div>

            <div class="detail-row">
                <span class="label">Name</span>
                <span>Juan Dela Cruz</span>
            </div>

            <div class="detail-row">
                <span class="label">Contact Number</span>
                <span>0917-123-4567</span>
            </div>

            <div class="detail-row">
                <span class="label">Address</span>
                <span>Maramag, Bukidnon</span>
            </div>

            <div class="actions">
                <a href="#" class="button">Edit Customer</a>
                <a href="#" class="button secondary-button">Back to Customers</a>
            </div>

        </section>

    </main>
</body>
</html>