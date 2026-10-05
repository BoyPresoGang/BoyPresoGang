<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>

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

        .required {
            color: #b02a37;
        }

        .form-note {
            margin-bottom: 20px;
            color: #6c757d;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }

        .field-error {
            color: #b02a37;
            font-size: 14px;
            margin-top: 6px;
        }

        .form-error {
            color: #b02a37;
            margin-top: 16px;
        }

        .form-success {
            color: #146c43;
            margin-top: 16px;
        }

        .actions {
            margin-top: 24px;
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

        .button:focus,
        button:focus {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            outline-offset: 2px;
        }

        .secondary-button {
            background: #6c757d;
        }
    </style>
</head>

<body>
    <main class="container">

        <header class="header">
            <h1>Edit Order</h1>
            <p class="description">
                Update the customer order information.
            </p>
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

                <p id="form-error" class="form-error"></p>
                <p id="form-success" class="form-success"></p>

                <div class="actions">
                    <button
                        id="submit-button"
                        type="submit"
                    >
                        Update Order
                    </button>

                    <a href="/orders" class="button secondary-button">
                        Cancel
                    </a>
                </div>

            </form>

        </section>

    </main>

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

            document.getElementById('form-error').textContent = '';
            document.getElementById('form-success').textContent = '';

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
                document.getElementById('form-error').textContent =
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
                    document.getElementById('form-success').textContent =
                        'Order updated successfully.';
                } else if (response.status === 422) {
                    const hasFieldErrors =
                        showOrderValidationErrors(result);
                    document.getElementById('form-error').textContent =
                        hasFieldErrors
                            ? 'Please correct the highlighted fields and try again.'
                            : 'Please review the order information and try again.';
                } else {
                    document.getElementById('form-error').textContent =
                        'Unable to update the order. Please try again later.';
                }
            } catch (error) {
                document.getElementById('form-error').textContent =
                    'Unable to reach the server. Please check your connection and try again.';
            } finally {
                orderSubmitButton.disabled = false;
                orderSubmitButton.textContent = 'Update Order';
            }
        });

        productSelect.addEventListener('change', updateProductStock);

        loadOrder();
    </script>
</body>
</html>
