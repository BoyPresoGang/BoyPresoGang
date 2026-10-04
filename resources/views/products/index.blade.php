<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Products</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 40px; background: #f8f9fa; color: #212529; } .container { max-width: 1100px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; } h1 { margin: 0; } .description { color: #6c757d; margin-top: 6px; }
        .button { display: inline-block; padding: 10px 16px; background: #212529; color: white; text-decoration: none; border: 0; border-radius: 6px; cursor: pointer; } .table-container, .state-message { background: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; } th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #dee2e6; } th { background: #f1f3f5; font-weight: 600; } tr:last-child td { border-bottom: none; } .actions a { margin-right: 10px; color: #212529; }
        .state-message { padding: 32px; margin-bottom: 20px; text-align: center; } .state-message h2 { margin-top: 0; } .state-message p { color: #6c757d; } .error-state { border-color: #dc3545; }
    </style>
</head>
<body><main class="container">
    <header class="header"><div><h1>Products</h1><p class="description">Manage water products and their available prices.</p></div><a href="/products/create" class="button">Add Product</a></header>
    <section id="loading-state" class="state-message" aria-label="Loading product list"><h2>Loading products...</h2><p>Please wait while the product records are being loaded.</p></section>
    <section id="empty-state" class="state-message" aria-label="Empty product list" hidden><h2>No products yet</h2><p>There are currently no products registered in the system.</p><a href="/products/create" class="button">Add Product</a></section>
    <section id="error-state" class="state-message error-state" aria-label="Product list error" hidden><h2>Unable to load products</h2><p id="error-message">Something went wrong while loading the product records.</p><button id="try-again" type="button" class="button">Try Again</button></section>
    <section id="list-state" class="table-container" aria-label="Product list" hidden><table><thead><tr><th>ID</th><th>Product Name</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead><tbody id="product-rows"></tbody></table></section>
</main><script>
const states = { loading: document.getElementById('loading-state'), empty: document.getElementById('empty-state'), error: document.getElementById('error-state'), list: document.getElementById('list-state') }, rows = document.getElementById('product-rows'), errorMessage = document.getElementById('error-message');
function showState(name) { Object.entries(states).forEach(([key, element]) => { element.hidden = key !== name; }); } function cell(value) { const e = document.createElement('td'); e.textContent = value == null ? '' : String(value); return e; }
function actions(id) { const e = document.createElement('td'); e.className = 'actions'; [['View', '/products/'], ['Edit', '/products/edit/']].forEach(([label, path]) => { const a = document.createElement('a'); a.href = path + encodeURIComponent(String(id)); a.textContent = label; e.append(a); }); return e; }
async function loadProducts() { showState('loading'); try { const response = await fetch('/api/products', { headers: { Accept: 'application/json' } }); if (!response.ok) throw new Error('The product service returned an error.'); const payload = await response.json(); if (!payload || !Array.isArray(payload.data) || payload.data.some(item => !item || item.id == null)) throw new Error('The product service returned an invalid response.'); rows.replaceChildren(); payload.data.forEach(product => { const row = document.createElement('tr'); const price = Number(product.price); row.append(cell(product.id), cell(product.name), cell(Number.isFinite(price) ? '₱' + price.toFixed(2) : product.price), cell(product.stock), actions(product.id)); rows.append(row); }); showState(payload.data.length ? 'list' : 'empty'); } catch (error) { errorMessage.textContent = error instanceof Error ? error.message : 'Please try again later.'; showState('error'); } }
document.getElementById('try-again').addEventListener('click', loadProducts); loadProducts();
</script></body></html>
