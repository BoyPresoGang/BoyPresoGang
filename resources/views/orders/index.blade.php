<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background: #f8f9fa;
            color: #212529;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0;
        }

        .description {
            color: #6c757d;
            margin-top: 6px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            background: #212529;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .table-container {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background: #f1f3f5;
            font-weight: 600;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .actions a {
            margin-right: 10px;
            color: #212529;
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
            <div>
                <h1>Orders</h1>
                <p class="description">
                    View and manage customer orders for water products.
                </p>
            </div>

            <a href="#" class="button">Create Order</a>
        </header>

        <section class="table-container" aria-label="Order list">
                    {{-- Empty State --}}
        <section class="state-message" aria-label="Empty order list">
            <h2>No orders yet</h2>
            <p>There are currently no orders registered in the system.</p>
            <a href="#" class="button">Create Order</a>
        </section>

        {{-- Loading State --}}
        <section class="state-message" aria-label="Loading order list">
            <h2>Loading orders...</h2>
            <p>Please wait while the order records are being loaded.</p>
        </section>

        {{-- Error State --}}
        <section class="state-message error-state" aria-label="Order list error">
            <h2>Unable to load orders</h2>
            <p>Something went wrong while loading the order records. Please try again.</p>
            <a href="#" class="button">Try Again</a>
        </section>

        {{-- Order List --}}
        <section class="table-container" aria-label="Order list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Juan Dela Cruz</td>
                        <td>5-Gallon Purified Water</td>
                        <td>3</td>
                        <td>Pending</td>
                        <td class="actions">
                            <a href="#">View</a>
                            <a href="#">Edit</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Maria Santos</td>
                        <td>5-Gallon Mineral Water</td>
                        <td>2</td>
                        <td>Completed</td>
                        <td class="actions">
                            <a href="#">View</a>
                            <a href="#">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>
</body>
</html>