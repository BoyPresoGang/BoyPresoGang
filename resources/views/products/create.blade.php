<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>

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
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
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
            <h1>Create Product</h1>
            <p class="description">
                Add a new water product to the station inventory.
            </p>
        </header>

        <section class="card" aria-label="Create product form">

            <form action="#" method="POST">

                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter product name"
                    >
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        min="0"
                        step="0.01"
                        placeholder="Enter product price"
                    >
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        placeholder="Enter available stock"
                    >
                </div>

                <div class="actions">
                    <button type="submit" class="button">Save Product</button>
                    <a href="#" class="button secondary-button">Cancel</a>
                </div>

            </form>

        </section>

    </main>
</body>
</html>