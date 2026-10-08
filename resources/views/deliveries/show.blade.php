@extends('layouts.app')

@section('title', 'Delivery Details')

@section('content')
<div class="container" style="max-width: 900px;">
    <header class="header">
        <div>
            <h1>Delivery Details</h1>
            <p class="description">View the complete information for this delivery.</p>
        </div>
    </header>

    <section class="state-message" data-state="not-found" aria-label="Delivery not found" hidden>
        <h2>Delivery not found</h2>
        <p>The requested delivery record was not found.</p>
        <a href="/deliveries" class="button secondary-button">Back to Deliveries</a>
    </section>

    <section class="state-message" data-state="loading" aria-label="Loading delivery details">
        <h2>Loading delivery details...</h2>
        <p>Please wait while the delivery information is being loaded.</p>
    </section>

    <section class="state-message error-state" data-state="error" aria-label="Delivery details error" hidden>
        <h2>Unable to load delivery</h2>
        <p data-error-message>The delivery information could not be loaded. Please try again.</p>
        <a href="#" class="button" data-retry="delivery">Try Again</a>
    </section>

    <section class="card" data-state="success" aria-label="Delivery details" hidden>
        <div class="detail-row">
            <span class="label">Delivery ID</span>
            <span id="delivery-id">-</span>
        </div>

        <div class="detail-row">
            <span class="label">Customer</span>
            <span id="delivery-customer-name">-</span>
        </div>

        <div class="detail-row">
            <span class="label">Product</span>
            <span id="delivery-product-name">-</span>
        </div>

        <div class="detail-row">
            <span class="label">Quantity</span>
            <span id="delivery-quantity">-</span>
        </div>

        <div class="detail-row">
            <span class="label">Delivery Date</span>
            <span id="delivery-date">-</span>
        </div>

        <div class="detail-row">
            <span class="label">Status</span>
            <span id="delivery-status">-</span>
        </div>

        <div class="actions" style="margin-top: 24px;">
            <a href="/deliveries" id="delivery-edit-link" class="button">Edit Delivery</a>
            <a href="/deliveries" class="button secondary-button">Back to Deliveries</a>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const endpoint = '/api/deliveries';
        const stateSections = {
            loading: document.querySelector('[data-state="loading"]'),
            error: document.querySelector('[data-state="error"]'),
            notFound: document.querySelector('[data-state="not-found"]'),
            success: document.querySelector('[data-state="success"]'),
        };
        const fields = {
            id: document.getElementById('delivery-id'),
            customer_name: document.getElementById('delivery-customer-name'),
            product_name: document.getElementById('delivery-product-name'),
            quantity: document.getElementById('delivery-quantity'),
            delivery_date: document.getElementById('delivery-date'),
            status: document.getElementById('delivery-status'),
        };
        const errorMessage = document.querySelector('[data-error-message]');
        const editLink = document.getElementById('delivery-edit-link');

        function setState(stateName) {
            Object.keys(stateSections).forEach(function (key) {
                if (stateSections[key]) {
                    stateSections[key].hidden = key !== stateName;
                }
            });
        }

        function showError(message) {
            errorMessage.textContent = message;
            setState('error');
        }

        function getRecordId() {
            const parts = window.location.pathname.split('/').filter(Boolean);
            return parts.length ? parts[parts.length - 1] : '';
        }

        function renderDelivery(record) {
            const order = record && record.order;
            fields.id.textContent = record && record.id !== undefined && record.id !== null ? record.id : 'N/A';
            fields.customer_name.textContent = order && order.customer && typeof order.customer.name === 'string'
                ? order.customer.name : (record.order_id ? 'N/A' : 'No associated order');
            fields.product_name.textContent = order && order.product && typeof order.product.name === 'string'
                ? order.product.name : (record.order_id ? 'N/A' : 'No associated order');
            fields.quantity.textContent = order && order.quantity !== undefined ? order.quantity : '—';
            fields.delivery_date.textContent = record && record.delivery_date ? record.delivery_date : 'N/A';
            fields.status.textContent = record && record.status ? record.status : 'N/A';
        }

        async function loadDelivery() {
            const id = getRecordId();
            setState('loading');

            if (!id) {
                setState('notFound');
                return;
            }

            if (editLink) {
                editLink.href = '/deliveries/edit/' + encodeURIComponent(id);
            }

            let response;
            try {
                response = await fetch(endpoint + '/' + encodeURIComponent(id));
            } catch (error) {
                showError("We couldn't connect to the server. Check your connection and try again.");
                return;
            }

            if (response.status === 404) {
                setState('notFound');
                return;
            }

            if (!response.ok) {
                showError(response.status >= 500
                    ? "The server is having trouble loading this delivery's information. Please try again."
                    : "We couldn't load this delivery's information. Please try again.");
                return;
            }

            let payload;
            try {
                payload = await response.json();
            } catch (error) {
                showError("The server returned an unexpected response. Please try again.");
                return;
            }

            if (!payload || typeof payload !== 'object' || payload.status !== 200
                || !payload.data || typeof payload.data !== 'object' || Array.isArray(payload.data)) {
                showError("The server returned an unexpected response. Please try again.");
                return;
            }

            renderDelivery(payload.data);
            setState('success');
        }

        const retryLink = document.querySelector('[data-retry="delivery"]');
        if (retryLink) {
            retryLink.addEventListener('click', function (event) {
                event.preventDefault();
                loadDelivery();
            });
        }

        loadDelivery();
    });
</script>
@endsection
