<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>

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
                <h1>Customers</h1>
                <p class="description">
                    Manage customers registered in the water refilling station.
                </p>
            </div>

            <a href="#" class="button">Add Customer</a>
        </header>

        <section class="table-container" aria-label="Customer list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Juan Dela Cruz</td>
                        <td>0917-123-4567</td>
                        <td>Maramag, Bukidnon</td>
                        <td class="actions">
                            <a href="#">View</a>
                            <a href="#">Edit</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Maria Santos</td>
                        <td>0918-987-6543</td>
                        <td>Quezon City</td>
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