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

        .secondary-button {
            background: #6c757d;
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

            <form action="#" method="POST">

                <div class="form-group">
                    <label for="customer">Customer</label>
                    <select id="customer" name="customer">
                        <option value="">Select a customer</option>
                        <option value="1">Juan Dela Cruz</option>
                        <option value="2">Maria Santos</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="product">Product</label>
                    <select id="product" name="product">
                        <option value="">Select a product</option>
                        <option value="1">5-Gallon Purified Water</option>
                        <option value="2">5-Gallon Mineral Water</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="1"
                        placeholder="Enter quantity"
                    >
                </div>

                <div class="actions">
                    <button type="submit" class="button">Save Order</button>
                    <a href="#" class="button secondary-button">Cancel</a>
                </div>

            </form>

        </section>

    </main>
</body>
</html>