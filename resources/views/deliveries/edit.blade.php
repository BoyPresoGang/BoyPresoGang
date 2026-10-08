@extends('layouts.app')

@section('title', 'Edit Delivery')

@section('content')
<div class="container container-medium">
    <header class="header">
        <div>
            <h1>Edit Delivery</h1>
            <p class="description">Update the delivery information and status.</p>
        </div>
    </header>

    <section class="card" aria-label="Edit delivery form">
        <form id="delivery-edit-form">
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
                <p id="order-note" class="form-note" aria-live="polite"></p>
                <p id="order_id-error" class="field-error" role="alert"></p>
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
                <p id="delivery_date-error" class="field-error" role="alert"></p>
            </div>

            <div class="form-group">
                <label for="status">
                    Status <span class="required">*</span>
                </label>
                <select
                    id="status"
                    name="status"
                    required
                    aria-required="true"
                    aria-describedby="status-error"
                >
                    <option value="scheduled">Scheduled</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <p id="status-error" class="field-error" role="alert"></p>
            </div>

            <p id="form-error" class="field-error" role="alert"></p>
            <p id="form-success" class="form-message success" role="status" style="display:none;"></p>

            <div class="actions" style="margin-top: 24px;">
                <button
                    id="submit-button"
                    type="submit"
                    class="button"
                >
                    Update Delivery
                </button>
                <a href="/deliveries" class="button secondary-button">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>

<script>
    const deliveryForm =
        document.getElementById('delivery-edit-form');

    const deliverySubmitButton =
        document.getElementById('submit-button');

    const deliveryId =
        window.location.pathname.split('/').filter(Boolean).pop() || '';

    const orderSelect = document.getElementById('order_id');
    const orderError = document.getElementById('order_id-error');
    const orderNote = document.getElementById('order-note');
    const deliveryDateInput = document.getElementById('delivery_date');
    const today = new Date();
    const localToday = today.getFullYear() + '-' +
        String(today.getMonth() + 1).padStart(2, '0') + '-' +
        String(today.getDate()).padStart(2, '0');
    deliveryDateInput.min = localToday;
    let deliveryRecord = null;
    let availableOrders = [];

    const deliveryFieldIds = [
        'order_id',
        'delivery_date',
        'status'
    ];

    function clearDeliveryFieldErrors() {
        deliveryFieldIds.forEach((fieldId) => {
            document.getElementById(fieldId)
                .removeAttribute('aria-invalid');
            document.getElementById(`${fieldId}-error`).textContent = '';
        });
    }

    function showDeliveryFieldError(fieldId, message) {
        if (!deliveryFieldIds.includes(fieldId)) {
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

    function showDeliveryValidationErrors(result) {
        let hasFieldErrors = false;

        if (result && typeof result.field === 'string') {
            hasFieldErrors = showDeliveryFieldError(
                result.field,
                result.error
            ) || hasFieldErrors;
        }

        if (result && result.errors &&
            typeof result.errors === 'object' &&
            !Array.isArray(result.errors)) {
            Object.entries(result.errors).forEach(
                ([fieldId, message]) => {
                    hasFieldErrors = showDeliveryFieldError(
                        fieldId,
                        message
                    ) || hasFieldErrors;
                }
            );
        }

        return hasFieldErrors;
    }

    function setOrderLoading(message) {
        orderSelect.replaceChildren();
        const option = document.createElement('option');
        option.value = '';
        option.textContent = message;
        option.selected = true;
        option.disabled = true;
        orderSelect.append(option);
        orderSelect.disabled = true;
    }

    async function loadOrders(currentOrderId) {
        orderError.textContent = '';
        orderError.classList.remove('visible');
        setOrderLoading('Loading orders...');

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
                .filter(delivery => ['scheduled', 'in_transit'].includes(delivery.status)
                    && delivery.order_id != null && String(delivery.id) !== String(deliveryId))
                .map(delivery => String(delivery.order_id)));
            const customers = new Map(customersPayload.data.map(item => [String(item.id), item.name]));
            const products = new Map(productsPayload.data.map(item => [String(item.id), item.name]));
            availableOrders = ordersPayload.data.filter(order => order && order.id != null
                && (!activeOrderIds.has(String(order.id)) || String(order.id) === String(currentOrderId)));

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
            orderSelect.value = currentOrderId ? String(currentOrderId) : '';
        } catch (error) {
            setOrderLoading('Unable to load orders');
            orderError.textContent =
                'Unable to load orders. Please refresh and try again.';
            orderError.classList.add('visible');
        }
    }

    async function loadDelivery() {
        try {
            const response =
                await fetch(`/api/deliveries/${deliveryId}`);

            if (!response.ok) {
                throw new Error('Unable to load delivery.');
            }

            const result = await response.json();
            deliveryRecord = result.data;
            const currentOrderId = deliveryRecord.order_id ?? '';
            await loadOrders(currentOrderId);
            if (!currentOrderId) {
                orderNote.textContent =
                    'This is a legacy delivery without an associated order. Select an order before saving.';
            } else {
                orderNote.textContent = '';
            }

            document.getElementById('delivery_date').value =
                result.data.delivery_date ?? '';

            document.getElementById('status').value =
                result.data.status ?? 'scheduled';

        } catch (error) {
            document.getElementById('form-error').textContent =
                'Unable to load the delivery. Please try again.';
        }
    }

    deliveryForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (deliverySubmitButton.disabled) {
            return;
        }

        deliverySubmitButton.disabled = true;
        deliverySubmitButton.textContent = 'Updating...';

        const formError = document.getElementById('form-error');
        const formSuccess = document.getElementById('form-success');
        formError.textContent = '';
        formSuccess.textContent = '';
        formSuccess.style.display = 'none';

        clearDeliveryFieldErrors();

        const data = {
            order_id:
                document.getElementById('order_id').value,

            delivery_date:
                document.getElementById('delivery_date').value,

            status:
                document.getElementById('status').value
        };

        if (data.delivery_date && data.delivery_date < localToday) {
            showDeliveryFieldError(
                'delivery_date',
                'The delivery date cannot be in the past.'
            );
            formError.textContent =
                'Please correct the highlighted fields and try again.';
            deliverySubmitButton.disabled = false;
            deliverySubmitButton.textContent = 'Update Delivery';
            return;
        }

        try {
            const response =
                await fetch(`/api/deliveries/${deliveryId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

            const result = await response.json();

            if (response.status === 200) {
                formSuccess.textContent =
                    'Delivery updated successfully.';
                formSuccess.style.display = 'block';
            } else if (response.status === 422) {
                const hasFieldErrors =
                    showDeliveryValidationErrors(result);
                formError.textContent =
                    hasFieldErrors
                        ? 'Please correct the highlighted fields and try again.'
                        : 'Please review the delivery information and try again.';
            } else {
                formError.textContent =
                    'Unable to update the delivery. Please try again later.';
            }

        } catch (error) {
            formError.textContent =
                'Unable to reach the server. Please check your connection and try again.';
        } finally {
            deliverySubmitButton.disabled = false;
            deliverySubmitButton.textContent = 'Update Delivery';
        }
    });

    loadDelivery();
</script>
@endsection
