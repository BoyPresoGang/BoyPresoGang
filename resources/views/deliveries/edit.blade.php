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

        input,
        select,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            background: white;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
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
            <h1>Edit Delivery</h1>
            <p class="description">
                Update the delivery information and status.
            </p>
        </header>

        <section class="card" aria-label="Edit delivery form">

            <form action="#" method="POST">

                <div class="form-group">
                    <label for="order">Order</label>
                    <select id="order" name="order">
                        <option value="1001" selected>#1001 - Juan Dela Cruz</option>
                        <option value="1002">#1002 - Maria Santos</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="address">Delivery Address</label>
                    <textarea
                        id="address"
                        name="address"
                    >Purok 1, Barangay Poblacion</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Delivery Status</label>
                    <select id="status" name="status">
                        <option value="pending" selected>Pending</option>
                        <option value="out_for_delivery">Out for Delivery</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>

                <div class="actions">
                    <button type="submit" class="button">Update Delivery</button>
                    <a href="#" class="button secondary-button">Cancel</a>
                </div>

            </form>

        </section>

    </main>
</body>
</html>