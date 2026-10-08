@extends('layouts.app')

@section('title', 'Deliveries')

@section('content')
<div class="container">
    <header class="header">
        <div>
            <h1>Deliveries</h1>
            <p class="description">Track and manage water product deliveries.</p>
        </div>
        <a href="/deliveries/create" class="button">Add Delivery</a>
    </header>

    <section id="action-feedback" class="state-message" aria-live="polite" hidden>
        <p id="action-message"></p>
        <button id="retry-delete" type="button" class="button" hidden>Try Cancel Again</button>
    </section>

    <section id="loading-state" class="state-message" aria-label="Loading delivery list">
        <h2>Loading deliveries...</h2>
        <p>Please wait while the delivery records are being loaded.</p>
    </section>

    <section id="empty-state" class="state-message" aria-label="Empty delivery list" hidden>
        <h2>No deliveries yet</h2>
        <p>There are currently no deliveries registered in the system.</p>
        <a href="/deliveries/create" class="button">Add Delivery</a>
    </section>

    <section id="error-state" class="state-message error-state" aria-label="Delivery list error" hidden>
        <h2>Unable to load deliveries</h2>
        <p id="error-message">Something went wrong while loading the delivery records.</p>
        <button id="try-again" type="button" class="button">Try Again</button>
    </section>

    <section id="list-state" class="table-container" aria-label="Delivery list" hidden>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="delivery-rows"></tbody>
        </table>
    </section>
</div>

<script>
const states = { loading: document.getElementById('loading-state'), empty: document.getElementById('empty-state'), error: document.getElementById('error-state'), list: document.getElementById('list-state') }, rows = document.getElementById('delivery-rows'), errorMessage = document.getElementById('error-message'), feedback = document.getElementById('action-feedback'), actionMessage = document.getElementById('action-message'), retryDelete = document.getElementById('retry-delete');
function showState(name) { Object.entries(states).forEach(([key, element]) => { element.hidden = key !== name; }); } function cell(value) { const e = document.createElement('td'); e.textContent = value == null ? '' : String(value); return e; } function actions(id) { const e = document.createElement('td'); e.className = 'actions'; [['View', '/deliveries/'], ['Edit', '/deliveries/edit/']].forEach(([label, path]) => { const a = document.createElement('a'); a.href = path + encodeURIComponent(String(id)); a.textContent = label; e.append(a); }); const remove = document.createElement('button'); remove.type = 'button'; remove.textContent = 'Cancel'; remove.addEventListener('click', () => cancelDelivery(id, remove)); e.append(remove); return e; }
function feedbackMessage(message, canRetry, retry, retryLabel) { actionMessage.textContent = message; retryDelete.hidden = !canRetry; retryDelete.textContent = retryLabel || 'Try Cancel Again'; retryDelete.onclick = retry || null; feedback.hidden = false; }
function requestError(status) { if (status === 403) return 'You are not authorized to cancel this delivery.'; if (status === 404) return 'This delivery was not found. Refresh the list and try again.'; if (status === 422) return 'The cancel request was invalid.'; if (status >= 500) return 'The server could not cancel this delivery. Please try again.'; return 'Unable to cancel this delivery. Please check your connection and try again.'; }
async function cancelDelivery(id, button) { if (!window.confirm('Cancel this delivery?')) return; button.disabled = true; button.textContent = 'Cancelling...'; feedbackMessage('Cancelling delivery...', false); const retry = () => cancelDelivery(id, button); try { const response = await fetch('/api/deliveries/' + encodeURIComponent(String(id)), { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' } }); if (!response.ok) { feedbackMessage(requestError(response.status), true, retry); return; } feedbackMessage('Delivery cancelled successfully.', false); const refreshed = await loadDeliveries(); if (!refreshed) { const retryRefresh = async () => { const retrySucceeded = await loadDeliveries(); if (retrySucceeded) { feedback.hidden = true; actionMessage.textContent = ''; } }; feedbackMessage('Delivery cancelled, but the list could not be refreshed.', true, retryRefresh, 'Try Refresh Again'); } } catch (error) { feedbackMessage('Network error while cancelling the delivery.', true, retry); } finally { button.disabled = false; button.textContent = 'Cancel'; } }
async function loadDeliveries() { retryDelete.disabled = true; showState('loading'); try { const response = await fetch('/api/deliveries', { headers: { Accept: 'application/json' } }); if (!response.ok) throw new Error('The delivery service returned an error.'); const payload = await response.json(); if (!payload || !Array.isArray(payload.data) || payload.data.some(item => !item || item.id == null)) throw new Error('The delivery service returned an invalid response.'); rows.replaceChildren(); payload.data.forEach(delivery => { const row = document.createElement('tr'); const order = delivery.order; row.append(cell(delivery.id), cell(order && order.customer ? order.customer.name : (delivery.order_id ? 'Customer unavailable' : 'No associated order')), cell(order && order.product ? order.product.name : (delivery.order_id ? 'Product unavailable' : 'No associated order')), cell(order ? order.quantity : '—'), cell(delivery.delivery_date), cell(delivery.status), actions(delivery.id)); rows.append(row); }); showState(payload.data.length ? 'list' : 'empty'); return true; } catch (error) { errorMessage.textContent = error instanceof Error ? error.message : 'Please try again later.'; showState('error'); return false; } finally { retryDelete.disabled = false; } }
document.getElementById('try-again').addEventListener('click', loadDeliveries); loadDeliveries();
</script>
@endsection
