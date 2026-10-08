@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container container-medium">
    <header class="header">
        <div>
            <h1>Edit Product</h1>
            <p class="description">Update the product information and inventory.</p>
        </div>
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
                    aria-describedby="name-error"
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
                    aria-describedby="price-error"
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
                    aria-describedby="stock-error"
                >
                <p id="stock-error" class="field-error" role="alert"></p>
            </div>

            <p id="form-error" class="field-error" role="alert"></p>
            <p id="form-success" class="form-message success" role="status" style="display:none;"></p>

            <div class="actions" style="margin-top: 24px;">
                <button id="submit-button" type="submit" class="button">
                    Update Product
                </button>
                <a href="/products" class="button secondary">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>

<script>
const productForm = document.getElementById('product-edit-form');
const productSubmitButton = document.getElementById('submit-button');

const productId =
    window.location.pathname.split('/').filter(Boolean).pop() || '';

const productFieldIds = ['name', 'price', 'stock'];

function clearProductFieldErrors() {
    productFieldIds.forEach((fieldId) => {
        document.getElementById(fieldId).removeAttribute('aria-invalid');
        document.getElementById(`${fieldId}-error`).textContent = '';
    });
}

function showProductFieldError(fieldId, message) {
    if (!productFieldIds.includes(fieldId)) {
        return false;
    }

    const label = document.querySelector(`label[for="${fieldId}"]`);
    const fieldName = label
        ? label.textContent.replace(/\s*\*$/, '').trim()
        : 'This field';
    const details = Array.isArray(message) ? message[0] : message;

    document.getElementById(fieldId).setAttribute('aria-invalid', 'true');
    document.getElementById(`${fieldId}-error`).textContent =
        `${fieldName}: ${
            typeof details === 'string' && details.trim()
                ? details
                : 'Please enter a valid value.'
        }`;
    return true;
}

function showProductValidationErrors(result) {
    let hasFieldErrors = false;

    if (result && typeof result.field === 'string') {
        hasFieldErrors = showProductFieldError(
            result.field,
            result.error
        ) || hasFieldErrors;
    }

    if (result && result.errors &&
        typeof result.errors === 'object' &&
        !Array.isArray(result.errors)) {
        Object.entries(result.errors).forEach(([fieldId, message]) => {
            hasFieldErrors = showProductFieldError(
                fieldId,
                message
            ) || hasFieldErrors;
        });
    }

    return hasFieldErrors;
}

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

    if (productSubmitButton.disabled) {
        return;
    }

    productSubmitButton.disabled = true;
    productSubmitButton.textContent = 'Updating...';

    const formError = document.getElementById('form-error');
    const formSuccess = document.getElementById('form-success');
    formError.textContent = '';
    formSuccess.textContent = '';
    formSuccess.style.display = 'none';

    clearProductFieldErrors();

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
            formSuccess.textContent = 'Product updated successfully.';
            formSuccess.style.display = 'block';
        } else if (response.status === 422) {
            const hasFieldErrors =
                showProductValidationErrors(result);

            formError.textContent =
                hasFieldErrors
                    ? 'Please correct the highlighted fields and try again.'
                    : 'Please review the product information and try again.';
        } else {
            formError.textContent =
                'Unable to update the product. Please try again later.';
        }

    } catch (error) {
        formError.textContent =
            'Unable to reach the server. Please check your connection and try again.';
    } finally {
        productSubmitButton.disabled = false;
        productSubmitButton.textContent = 'Update Product';
    }
});

loadProduct();
</script>
@endsection
