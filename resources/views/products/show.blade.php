<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>

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
            <h1>Product Details</h1>
            <p class="description">
                View the complete information for this product.
            </p>
        </header>

        <section class="state-message" data-state="not-found" aria-label="Product not found" hidden>
            <h2>Product not found</h2>
            <p>The requested product record was not found.</p>
            <a href="/products" class="button secondary-button">Back to Products</a>
        </section>

        <section class="state-message" data-state="loading" aria-label="Loading product details">
            <h2>Loading product details...</h2>
            <p>Please wait while the product information is being loaded.</p>
        </section>

        <section class="state-message error-state" data-state="error" aria-label="Product details error" hidden>
            <h2>Unable to load product</h2>
            <p>Something went wrong while loading this product's information.</p>
            <a href="#" class="button" data-retry="product">Try Again</a>
        </section>

        <section class="card" data-state="success" aria-label="Product details" hidden>
            <div class="detail-row">
                <span class="label">Product ID</span>
                <span id="product-id">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Product Name</span>
                <span id="product-name">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Price</span>
                <span id="product-price">-</span>
            </div>

            <div class="detail-row">
                <span class="label">Stock</span>
                <span id="product-stock">-</span>
            </div>

            <div class="actions">
                <a href="#" id="product-edit-link" class="button">Edit Product</a>
                <a href="/products" class="button secondary-button">Back to Products</a>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const endpoint = '/api/products';
            const stateSections = {
                loading: document.querySelector('[data-state="loading"]'),
                error: document.querySelector('[data-state="error"]'),
                notFound: document.querySelector('[data-state="not-found"]'),
                success: document.querySelector('[data-state="success"]'),
            };
            const fields = {
                id: document.getElementById('product-id'),
                name: document.getElementById('product-name'),
                price: document.getElementById('product-price'),
                stock: document.getElementById('product-stock'),
            };
            const editLink = document.getElementById('product-edit-link');

            function setState(stateName) {
                Object.keys(stateSections).forEach(function (key) {
                    if (stateSections[key]) {
                        stateSections[key].hidden = key !== stateName;
                    }
                });
            }

            function getRecordId() {
                const parts = window.location.pathname.split('/').filter(Boolean);
                return parts.length ? parts[parts.length - 1] : '';
            }

            function renderProduct(record) {
                fields.id.textContent = record && record.id !== undefined && record.id !== null ? record.id : 'N/A';
                fields.name.textContent = record && record.name ? record.name : 'N/A';

                if (record && record.price !== undefined && record.price !== null) {
                    const priceValue = Number(record.price);
                    fields.price.textContent = Number.isFinite(priceValue) ? '₱' + priceValue.toFixed(2) : record.price;
                } else {
                    fields.price.textContent = 'N/A';
                }

                fields.stock.textContent = record && record.stock !== undefined && record.stock !== null ? record.stock : 'N/A';
            }

            async function loadProduct() {
                const id = getRecordId();
                setState('loading');

                if (!id) {
                    setState('notFound');
                    return;
                }

                if (editLink) {
                    editLink.href = '/products/edit/' + encodeURIComponent(id);
                }

                try {
                    const response = await fetch(endpoint + '/' + encodeURIComponent(id));
                    const payload = await response.json().catch(function () {
                        return null;
                    });

                    if (response.status === 404 || payload === null || payload.status !== 200 || !payload.data) {
                        setState('notFound');
                        return;
                    }

                    renderProduct(payload.data);
                    setState('success');
                } catch (error) {
                    setState('error');
                }
            }

            const retryLink = document.querySelector('[data-retry="product"]');
            if (retryLink) {
                retryLink.addEventListener('click', function (event) {
                    event.preventDefault();
                    loadProduct();
                });
            }

            loadProduct();
        });
    </script>
</body>
</html>
