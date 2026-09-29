<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliveries</title>

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
    </style>
</head>

<body>
    <main class="container">

        <header class="header">
            <div>
                <h1>Deliveries</h1>
                <p class="description">
                    Track and manage water product deliveries.
                </p>
            </div>

            <a href="#" class="button">Add Delivery</a>
        </header>

        <section class="table-container" aria-label="Delivery list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Delivery Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>#1001</td>
                        <td>Juan Dela Cruz</td>
                        <td>Maramag, Bukidnon</td>
                        <td>Pending</td>
                        <td class="actions">
                            <a href="#">View</a>
                            <a href="#">Edit</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>#1002</td>
                        <td>Maria Santos</td>
                        <td>Quezon City</td>
                        <td>Delivered</td>
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