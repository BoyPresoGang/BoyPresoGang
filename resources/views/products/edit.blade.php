<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <style>
        .page {
            max-width: 800px;
            margin: 0 auto;
            padding: 24px;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
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

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-group input:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }

        button,
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

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .secondary {
            background: #6c757d;
        }

        .field-error,
        .form-error {
            color: #b02a37;
            margin: 6px 0 0;
        }

        .form-success {
            color: #146c43;
            margin: 6px 0 12px;
        }
    </style>
</head>

<body>

<div class="page">

    <header class="page-header">
        <h1>Edit Product</h1>
        <p class="description">
            Update the product information and inventory.
        </p>
    </header>

    <section class="card">

        <form id="product-edit-form">

            <div class="form-group">
                <label for="name">
                    Product Name <span aria-hidden="true">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    minlength="2"
                    maxlength="100"
                >

                <p id="name-error" class="field-error" role="alert"></p>
            </div>

            <div class="form-group">
                <label for="price">
                    Price <span aria-hidden="true">*</span>
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    required
                    min="0"
                    step="0.01"
                >

                <p id="price-error" class="field-error" role="alert"></p>
            </div>

            <div class="form-group">
                <label for="stock">
                    Stock <span aria-hidden="true">*</span>
                </label>

                <input
                    type="number"
                    id="stock"
                    name="stock"
                    required
                    min="0"
                    step="1"
                >

                <p id="stock-error" class="field-error" role="alert"></p>
            </div>

            <p id="form-error" class="form-error" role="alert"></p>

            <p id="form-success" class="form-success" role="status"></p>

            <button id="submit-button" type="submit">
                Update Product
            </button>

            <a href="#" class="button secondary">
                Cancel
            </a>

        </form>

    </section>

</div>

<script>
const productForm = document.getElementById('product-edit-form');
const productSubmitButton = document.getElementById('submit-button');

const productId =
    new URLSearchParams(window.location.search).get('id') || 1;


async function loadProduct() {

    try {

        const response =
            await fetch(`/api/products/${productId}`);

        if (!response.ok) {
            throw new Error('Unable to load product.');
        }

        const result = await response.json();

        document.getElementById('name').value =
            result.data.name ?? '';

        document.getElementById('price').value =
            result.data.price ?? '';

        document.getElementById('stock').value =
            result.data.stock ?? '';

    } catch (error) {

        document.getElementById('form-error').textContent =
            'Unable to load the product. Please try again.';
    }
}


productForm.addEventListener('submit', async (event) => {

    event.preventDefault();

    productSubmitButton.disabled = true;
    productSubmitButton.textContent = 'Updating...';

    document.getElementById('form-error').textContent = '';
    document.getElementById('form-success').textContent = '';

    document.getElementById('name-error').textContent = '';
    document.getElementById('price-error').textContent = '';
    document.getElementById('stock-error').textContent = '';


    const data = {

        name: document.getElementById('name').value,

        price: document.getElementById('price').value,

        stock: document.getElementById('stock').value

    };


    try {

        const response = await fetch(
            `/api/products/${productId}`,
            {
                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify(data)
            }
        );


        const result = await response.json();


        if (response.status === 200) {

            document.getElementById('form-success').textContent =
                'Product updated successfully.';

        } else if (response.status === 422) {

            const field = result.field;
            const message = result.error;

            const fieldError =
                document.getElementById(`${field}-error`);

            if (fieldError) {

                fieldError.textContent = message;

            } else {

                document.getElementById('form-error').textContent =
                    message;
            }

        } else {

            document.getElementById('form-error').textContent =
                'The product could not be updated.';
        }

    } catch (error) {

        document.getElementById('form-error').textContent =
            'A network error occurred. Please try again.';

    } finally {

        productSubmitButton.disabled = false;
        productSubmitButton.textContent = 'Update Product';
    }

});


loadProduct();
</script>

</body>
</html>