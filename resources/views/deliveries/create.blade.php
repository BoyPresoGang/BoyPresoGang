@extends('layouts.app')

@section('title', 'Create Delivery')

@section('content')
<style>
    .message {
        display: none;
        margin-bottom: 20px;
        padding: 12px 16px;
        border-radius: 6px;
    }

    .message.success {
        display: block;
        background: #d1e7dd;
        color: #0f5132;
    }

    .message.error {
        display: block;
        background: #f8d7da;
        color: #842029;
    }

    .field-error {
        display: none;
        margin-top: 6px;
        color: #b02a37;
        font-size: 14px;
    }

    .field-error.visible {
        display: block;
    }

    .input-error {
        border-color: #b02a37;
    }
</style>

<div class="container container-narrow">
    <header class="header">
        <div>
            <h1>Create Delivery</h1>
            <p class="description">Create a new delivery record for a customer.</p>
        </div>
    </header>

    <section class="card" aria-label="Create delivery form">
        <div
            id="form-message"
            class="message"
            role="alert"
            aria-live="polite"
        ></div>

        <form id="delivery-form">
            <p class="form-note">
                <span class="required">*</span> Required fields
            </p>

            <div class="form-group">
                <label for="order_id">
                    Order <span class="required">*</span>
                </label>
                <select
                    id="order_id"
                    name="order_id"
                    required
                    aria-required="true"
                    aria-describedby="order_id-error"
                >
                    <option value="">Loading orders...</option>
                </select>
                <div
                    id="order_id-error"
                    class="field-error"
                    aria-live="polite"
                ></div>
            </div>

            <div class="form-group">
                <label for="delivery_date">
                    Delivery Date <span class="required">*</span>
                </label>
                <input
                    type="date"
                    id="delivery_date"
                    name="delivery_date"
                    required
                    aria-required="true"
                    aria-describedby="delivery_date-error"
                >
                <div
                    id="delivery_date-error"
                    class="field-error"
                    aria-live="polite"
                ></div>
            </div>

            <div class="form-group">
                <label for="status">
                    Delivery Status <span class="required">*</span>
                </label>
                <select
                    id="status"
                    name="status"
                    required
                    aria-required="true"
                    aria-describedby="status-error"
                >
                    <option value="">Select delivery status</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <div
                    id="status-error"
                    class="field-error"
                    aria-live="polite"
                ></div>
            </div>

            <div class="actions" style="margin-top: 24px;">
                <button
                    type="submit"
                    id="submit-button"
                    class="button"
                >
                    Save Delivery
                </button>
                <a href="/deliveries" class="button secondary-button">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>

<script>
    const deliveryForm = document.getElementById('delivery-form');
    const submitButton = document.getElementById('submit-button');
    const formMessage = document.getElementById('form-message');
    const orderSelect = document.getElementById('order_id');
    const orderError = document.getElementById('order_id-error');
    const deliveryDateInput = document.getElementById('delivery_date');
    const today = new Date();
    const localToday = today.getFullYear() + '-' +
        String(today.getMonth() + 1).padStart(2, '0') + '-' +
        String(today.getDate()).padStart(2, '0');
    deliveryDateInput.min = localToday;

    const fieldIds = [
        'order_id',
        'delivery_date',
        'status'
    ];

    function clearMessages() {
        formMessage.className = 'message';
        formMessage.textContent = '';

        fieldIds.forEach(function (fieldId) {
            const field = document.getElementById(fieldId);
            const error = document.getElementById(fieldId + '-error');

            field.classList.remove('input-error');
            error.classList.remove('visible');
            error.textContent = '';
        });
    }

    function showMessage(type, message) {
        formMessage.className = 'message ' + type;
        formMessage.textContent = message;
    }

    function setLoadingOption(message) {
        orderSelect.replaceChildren();
        const option = document.createElement('option');
        option.value = '';
        option.textContent = message;
        option.selected = true;
        option.disabled = true;
        orderSelect.append(option);
        orderSelect.disabled = true;
    }

    async function loadOrders() {
        orderError.textContent = '';
        orderError.classList.remove('visible');
        setLoadingOption('Loading orders...');

        try {
            const [ordersResponse, deliveriesResponse, customersResponse, productsResponse] = await Promise.all([
                fetch('/api/orders', { headers: { 'Accept': 'application/json' } }),
                fetch('/api/deliveries', { headers: { 'Accept': 'application/json' } }),
                fetch('/api/customers', { headers: { 'Accept': 'application/json' } }),
                fetch('/api/products', { headers: { 'Accept': 'application/json' } })
            ]);

            if (!ordersResponse.ok || !deliveriesResponse.ok || !customersResponse.ok || !productsResponse.ok) {
                throw new Error('order data request failed');
            }

            const [ordersPayload, deliveriesPayload, customersPayload, productsPayload] = await Promise.all([
                ordersResponse.json(), deliveriesResponse.json(), customersResponse.json(), productsResponse.json()
            ]);

            if (!ordersPayload || ordersPayload.status !== 200 || !Array.isArray(ordersPayload.data)
                || !deliveriesPayload || deliveriesPayload.status !== 200 || !Array.isArray(deliveriesPayload.data)
                || !customersPayload || customersPayload.status !== 200 || !Array.isArray(customersPayload.data)
                || !productsPayload || productsPayload.status !== 200 || !Array.isArray(productsPayload.data)) {
                throw new Error('invalid order response');
            }

            const activeOrderIds = new Set(deliveriesPayload.data
                .filter(delivery => ['scheduled', 'in_transit'].includes(delivery.status) && delivery.order_id != null)
                .map(delivery => String(delivery.order_id)));
            const customers = new Map(customersPayload.data.map(item => [String(item.id), item.name]));
            const products = new Map(productsPayload.data.map(item => [String(item.id), item.name]));
            const availableOrders = ordersPayload.data.filter(order => order && order.id != null && !activeOrderIds.has(String(order.id)));

            orderSelect.replaceChildren();

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = availableOrders.length
                ? 'Select an order'
                : 'No orders are currently available for delivery.';
            placeholder.selected = true;
            placeholder.disabled = availableOrders.length === 0;
            orderSelect.append(placeholder);

            availableOrders.forEach(function (order) {
                const option = document.createElement('option');
                option.value = String(order.id);
                option.textContent = (customers.get(String(order.customer_id)) || 'Customer unavailable') + ' — ' +
                    (products.get(String(order.product_id)) || 'Product unavailable') + ' × ' + order.quantity;
                orderSelect.append(option);
            });

            orderSelect.disabled = availableOrders.length === 0;
        } catch (error) {
            setLoadingOption('Unable to load orders');
            orderError.textContent =
                'Unable to load orders. Please refresh and try again.';
            orderError.classList.add('visible');
        }
    }

    function showFieldError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + '-error');

        if (!field || !error || !fieldIds.includes(fieldId)) {
            return false;
        }

        const label = document.querySelector('label[for="' + fieldId + '"]');
        const fieldName = label
            ? label.textContent.replace(/\s*\*$/, '').trim()
            : 'This field';
        const details = Array.isArray(message) ? message[0] : message;

        field.classList.add('input-error');
        error.textContent = fieldName + ': ' +
            (typeof details === 'string' && details.trim()
                ? details
                : 'Please enter a valid value.');
        error.classList.add('visible');
        return true;
    }

    function showValidationErrors(result) {
        let hasFieldErrors = false;

        if (result && typeof result.field === 'string') {
            hasFieldErrors = showFieldError(
                result.field,
                result.error
            ) || hasFieldErrors;
        }

        if (result && result.errors &&
            typeof result.errors === 'object' &&
            !Array.isArray(result.errors)) {
            Object.entries(result.errors).forEach(function (entry) {
                hasFieldErrors = showFieldError(
                    entry[0],
                    entry[1]
                ) || hasFieldErrors;
            });
        }

        return hasFieldErrors;
    }

    deliveryForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        if (submitButton.disabled) {
            return;
        }

        clearMessages();

        submitButton.disabled = true;
        submitButton.textContent = 'Saving...';

        const data = {
            order_id: Number(
                document.getElementById('order_id').value
            ),
            delivery_date: document.getElementById('delivery_date').value,
            status: document.getElementById('status').value
        };

        if (data.delivery_date && data.delivery_date < localToday) {
            showFieldError(
                'delivery_date',
                'The delivery date cannot be in the past.'
            );
            showMessage(
                'error',
                'Please correct the highlighted fields and try again.'
            );
            submitButton.disabled = false;
            submitButton.textContent = 'Save Delivery';
            return;
        }

        try {
            const response = await fetch('/api/deliveries', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.status === 201) {
                showMessage(
                    'success',
                    'Delivery created successfully.'
                );

                deliveryForm.reset();

            } else if (response.status === 422) {
                const hasFieldErrors = showValidationErrors(result);
                showMessage(
                    'error',
                    hasFieldErrors
                        ? 'Please correct the highlighted fields and try again.'
                        : 'Please review the delivery information and try again.'
                );

            } else {
                showMessage(
                    'error',
                    'Unable to create the delivery. Please try again later.'
                );
            }

        } catch (error) {
            showMessage(
                'error',
                'Unable to reach the server. Please check your connection and try again.'
            );

        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Save Delivery';
        }
    });

    loadOrders();
</script>
@endsection
