@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="container container-medium">
    <header class="header">
        <div>
            <h1>Edit Order</h1>
            <p class="description">Update the customer order information.</p>
        </div>
    </header>

    <section class="card" aria-label="Edit order form">
        <form id="order-edit-form">
            <p class="form-note">
                <span class="required">*</span> Required fields
            </p>

            <div class="form-group">
                <label for="customer_id">
                    Customer <span class="required">*</span>
                </label>
                <select
                    id="customer_id"
                    name="customer_id"
                    required
                    aria-required="true"
                    aria-describedby="customer_id-error"
                >
                    <option value="">Loading customers...</option>
                </select>
                <p id="customer_id-error" class="field-error" role="alert"></p>
            </div>

            <div class="form-group">
                <label for="product_id">
                    Product <span class="required">*</span>
                </label>
                <select
                    id="product_id"
                    name="product_id"
                    required
                    aria-required="true"
                    aria-describedby="product_id-error"
                >
                    <option value="">Loading products...</option>
                </select>
                <p id="product-stock" class="form-note" aria-live="polite">
                    Select a product to see available stock.
                </p>
                <p id="product_id-error" class="field-error" role="alert"></p>
            </div>

            <div class="form-group">
                <label for="quantity">
                    Quantity <span class="required">*</span>
                </label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="1"
                    required
                    aria-required="true"
                    aria-describedby="quantity-error"
                >
                <p id="quantity-error" class="field-error" role="alert"></p>
            </div>

            <p id="form-error" class="field-error" role="alert"></p>
            <p id="form-success" class="form-message success" role="status" style="display:none;"></p>

            <div class="actions" style="margin-top: 24px;">
                <button
                    id="submit-button"
                    type="submit"
                    class="button"
                >
                    Update Order
                </button>
                <a href="/orders" class="button secondary-button">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>

<script>
    const orderForm = document.getElementById('order-edit-form');
    const orderSubmitButton = document.getElementById('submit-button');
    const customerSelect = document.getElementById('customer_id');
    const productSelect = document.getElementById('product_id');
    const productStock = document.getElementById('product-stock');
    const quantityInput = document.getElementById('quantity');
    let originalProductId = '';
    let originalQuantity = 0;

    const orderId =
        window.location.pathname.split('/').filter(Boolean).pop() || '';

    const orderFieldIds = [
        'customer_id',
        'product_id',
        'quantity'
    ];

    function clearOrderFieldErrors() {
        orderFieldIds.forEach((fieldId) => {
            document.getElementById(fieldId)
                .removeAttribute('aria-invalid');
            document.getElementById(`${fieldId}-error`).textContent = '';
        });
    }

    function showOrderFieldError(fieldId, message) {
        if (!orderFieldIds.includes(fieldId)) {
            return false;
        }

        const label = document.querySelector(`label[for="${fieldId}"]`);
        const fieldName = label
            ? label.textContent.replace(/\s*\*$/, '').trim()
            : 'This field';
        const details = Array.isArray(message) ? message[0] : message;

        document.getElementById(fieldId)
            .setAttribute('aria-invalid', 'true');
        document.getElementById(`${fieldId}-error`).textContent =
            `${fieldName}: ${
                typeof details === 'string' && details.trim()
                    ? details
                    : 'Please enter a valid value.'
            }`;
        return true;
    }

    function showOrderValidationErrors(result) {
        let hasFieldErrors = false;

        if (result && typeof result.field === 'string') {
            hasFieldErrors = showOrderFieldError(
                result.field,
                result.error
            ) || hasFieldErrors;
        }

        if (result && result.errors &&
            typeof result.errors === 'object' &&
            !Array.isArray(result.errors)) {
            Object.entries(result.errors).forEach(
                ([fieldId, message]) => {
                    hasFieldErrors = showOrderFieldError(
                        fieldId,
                        message
                    ) || hasFieldErrors;
                }
            );
        }

        return hasFieldErrors;
    }

    function setSelectMessage(select, message) {
        select.replaceChildren();
        const option = document.createElement('option');
        option.value = '';
        option.textContent = message;
        option.selected = true;
        select.append(option);
        select.disabled = true;
    }

    function getAvailableStock() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const stock = selectedOption ? Number(selectedOption.dataset.stock) : NaN;

        if (!productSelect.value || !Number.isInteger(stock) || stock < 0) {
            return NaN;
        }

        if (productSelect.value === originalProductId) {
            return stock + originalQuantity;
        }

        return stock;
    }

    function updateProductStock() {
        const availableStock = getAvailableStock();

        if (!productSelect.value || !Number.isInteger(availableStock)
            || availableStock < 0) {
            productStock.textContent = 'Select a product to see available stock.';
            quantityInput.removeAttribute('max');
            return;
        }

        productStock.textContent = 'Available stock for this order: ' + availableStock;
        quantityInput.max = String(availableStock);
    }

    function populateSelect(select, records, emptyMessage) {
        select.replaceChildren();

        if (!records.length) {
            setSelectMessage(select, emptyMessage);
            return;
        }

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Select an option';
        placeholder.selected = true;
        select.append(placeholder);

        records.forEach((record) => {
            const option = document.createElement('option');
            option.value = String(record.id);
            option.textContent = record.name;
            if (select === productSelect && Number.isInteger(Number(record.stock))
                && Number(record.stock) >= 0) {
                option.dataset.stock = String(record.stock);
            }
            select.append(option);
        });

        select.disabled = false;
    }

    async function loadOptions(endpoint, select, label, emptyMessage) {
        setSelectMessage(select, `Loading ${label}...`);

        try {
            const response = await fetch(endpoint);
            if (!response.ok) {
                throw new Error(`Unable to load ${label}. Please try again.`);
            }

            const payload = await response.json();
            if (!payload || payload.status !== 200 || !Array.isArray(payload.data)
                || payload.data.some(record => !record || record.id == null
                    || typeof record.name !== 'string')) {
                throw new Error(`Unable to load ${label}. Please try again.`);
            }

            populateSelect(select, payload.data, emptyMessage);
            return payload.data;
        } catch (error) {
            setSelectMessage(select, `Unable to load ${label}. Please refresh and try again.`);
            throw error;
        }
    }

    async function loadOrder() {
        try {
            const [customers, products] = await Promise.all([
                loadOptions('/api/customers', customerSelect, 'customers', 'No customers available'),
                loadOptions('/api/products', productSelect, 'products', 'No products available')
            ]);

            const response = await fetch(`/api/orders/${orderId}`);

            if (!response.ok) {
                throw new Error('Unable to load order.');
            }

            const result = await response.json();

            if (!result || result.status !== 200 || !result.data || typeof result.data !== 'object') {
                throw new Error('Unable to load order.');
            }

            populateSelect(customerSelect, customers, 'No customers available');
            populateSelect(productSelect, products, 'No products available');

            customerSelect.value =
                result.data.customer_id ?? '';

            productSelect.value =
                result.data.product_id ?? '';

            originalProductId = String(result.data.product_id ?? '');
            originalQuantity = Number(result.data.quantity ?? 0);
            updateProductStock();

            document.getElementById('quantity').value =
                result.data.quantity ?? '';
        } catch (error) {
            document.getElementById('form-error').textContent =
                'Unable to load the order. Please try again.';
        }
    }

    orderForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (orderSubmitButton.disabled) {
            return;
        }

        orderSubmitButton.disabled = true;
        orderSubmitButton.textContent = 'Updating...';

        const formError = document.getElementById('form-error');
        const formSuccess = document.getElementById('form-success');
        formError.textContent = '';
        formSuccess.textContent = '';
        formSuccess.style.display = 'none';

        clearOrderFieldErrors();

        const data = {
            customer_id:
                document.getElementById('customer_id').value,

            product_id:
                document.getElementById('product_id').value,

            quantity:
                document.getElementById('quantity').value
        };

        const availableStock = getAvailableStock();

        if (Number.isInteger(availableStock)
            && data.quantity > availableStock) {
            showOrderFieldError(
                'quantity',
                'The requested quantity exceeds the available stock.'
            );
            formError.textContent =
                'Please correct the highlighted fields and try again.';
            orderSubmitButton.disabled = false;
            orderSubmitButton.textContent = 'Update Order';
            return;
        }

        try {
            const response = await fetch(`/api/orders/${orderId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.status === 200) {
                formSuccess.textContent = 'Order updated successfully.';
                formSuccess.style.display = 'block';
            } else if (response.status === 422) {
                const hasFieldErrors =
                    showOrderValidationErrors(result);
                formError.textContent =
                    hasFieldErrors
                        ? 'Please correct the highlighted fields and try again.'
                        : 'Please review the order information and try again.';
            } else {
                formError.textContent =
                    'Unable to update the order. Please try again later.';
            }
        } catch (error) {
            formError.textContent =
                'Unable to reach the server. Please check your connection and try again.';
        } finally {
            orderSubmitButton.disabled = false;
            orderSubmitButton.textContent = 'Update Order';
        }
    });

    productSelect.addEventListener('change', updateProductStock);

    loadOrder();
</script>
@endsection
