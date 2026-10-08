@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container">
    <header class="header">
        <div>
            <h1>Products</h1>
            <p class="description">Manage water products and their available prices.</p>
        </div>
        <a href="/products/create" class="button">Add Product</a>
    </header>

    <section id="action-feedback" class="state-message" aria-live="polite" hidden>
        <p id="action-message"></p>
        <button id="retry-delete" type="button" class="button" hidden>Try Delete Again</button>
    </section>

    <section id="loading-state" class="state-message" aria-label="Loading product list" role="status" aria-live="polite" aria-busy="true">
        <h2>Loading products...</h2>
        <p>Please wait while the product records are being loaded.</p>
    </section>

    <section id="empty-state" class="state-message" aria-label="Empty product list" hidden>
        <h2>No products yet</h2>
        <p>There are currently no products registered in the system.</p>
        <a href="/products/create" class="button">Add Product</a>
    </section>

    <section id="error-state" class="state-message error-state" aria-label="Product list error" role="alert" aria-live="assertive" hidden>
        <h2>Unable to load products</h2>
        <p id="error-message">Something went wrong while loading the product records.</p>
        <button id="try-again" type="button" class="button">Retry loading products</button>
    </section>

    <section id="list-state" class="table-container" aria-label="Product list" hidden>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="product-rows"></tbody>
        </table>
    </section>
</div>

<script>
const states = { loading: document.getElementById('loading-state'), empty: document.getElementById('empty-state'), error: document.getElementById('error-state'), list: document.getElementById('list-state') }, rows = document.getElementById('product-rows'), errorMessage = document.getElementById('error-message'), feedback = document.getElementById('action-feedback'), actionMessage = document.getElementById('action-message'), retryDelete = document.getElementById('retry-delete');
function showState(name) { Object.entries(states).forEach(([key, element]) => { element.hidden = key !== name; }); } function cell(value) { const e = document.createElement('td'); e.textContent = value == null ? '' : String(value); return e; }
function actions(id) { const e = document.createElement('td'); e.className = 'actions'; [['View', '/products/'], ['Edit', '/products/edit/']].forEach(([label, path]) => { const a = document.createElement('a'); a.href = path + encodeURIComponent(String(id)); a.textContent = label; e.append(a); }); const remove = document.createElement('button'); remove.type = 'button'; remove.textContent = 'Delete'; remove.addEventListener('click', () => deleteProduct(id, remove)); e.append(remove); return e; }
function feedbackMessage(message, canRetry, retry) { actionMessage.textContent = message; retryDelete.hidden = !canRetry; retryDelete.onclick = retry || null; feedback.hidden = false; }
function requestError(status) { if (status === 403) return 'You are not authorized to delete this product.'; if (status === 404) return 'This product was not found. Refresh the list and try again.'; if (status === 422) return 'The delete request was invalid.'; if (status >= 500) return 'The server could not delete this product. Please try again.'; return 'Unable to delete this product. Please check your connection and try again.'; }
async function deleteProduct(id, button) { if (!window.confirm('Delete this product? This action cannot be undone.')) return; button.disabled = true; button.textContent = 'Deleting...'; feedbackMessage('Deleting product...', false); const retry = () => deleteProduct(id, button); try { const response = await fetch('/api/products/' + encodeURIComponent(String(id)), { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' } }); if (!response.ok) { feedbackMessage(requestError(response.status), true, retry); return; } feedbackMessage('Product deleted successfully.', false); await loadProducts(); } catch (error) { feedbackMessage('Network error while deleting the product.', true, retry); } finally { button.disabled = false; button.textContent = 'Delete'; } }
async function loadProducts() { showState('loading'); try { const response = await fetch('/api/products', { headers: { Accept: 'application/json' } }); if (!response.ok) throw new Error('The product service returned an error.'); const payload = await response.json(); if (!payload || !Array.isArray(payload.data) || payload.data.some(item => !item || item.id == null)) throw new Error('The product service returned an invalid response.'); rows.replaceChildren(); payload.data.forEach(product => { const row = document.createElement('tr'); const price = Number(product.price); row.append(cell(product.id), cell(product.name), cell(Number.isFinite(price) ? '₱' + price.toFixed(2) : product.price), cell(product.stock), actions(product.id)); rows.append(row); }); showState(payload.data.length ? 'list' : 'empty'); } catch (error) { errorMessage.textContent = error instanceof Error ? error.message : 'Please try again later.'; showState('error'); } }
document.getElementById('try-again').addEventListener('click', loadProducts); loadProducts();
</script>
@endsection
