<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 40px; background: #f8f9fa; color: #212529; }
        .container { max-width: 1100px; margin: 0 auto; } .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        h1 { margin: 0; } .description { color: #6c757d; margin-top: 6px; } .button { display: inline-block; padding: 10px 16px; background: #212529; color: white; text-decoration: none; border: 0; border-radius: 6px; cursor: pointer; }
        .table-container, .state-message { background: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; } th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #dee2e6; } th { background: #f1f3f5; font-weight: 600; } tr:last-child td { border-bottom: none; }
        .actions a, .actions button { margin-right: 10px; color: #212529; } .actions button { background: none; border: 0; padding: 0; cursor: pointer; font: inherit; text-decoration: underline; } .state-message { padding: 32px; margin-bottom: 20px; text-align: center; } .state-message h2 { margin-top: 0; } .state-message p { color: #6c757d; } .error-state { border-color: #dc3545; }
    </style>
</head>
<body>
<main class="container">
    <header class="header"><div><h1>Customers</h1><p class="description">Manage customers registered in the water refilling station.</p></div><a href="/customers/create" class="button">Add Customer</a></header>
    <section id="action-feedback" class="state-message" aria-live="polite" hidden><p id="action-message"></p><button id="retry-delete" type="button" class="button" hidden>Try Delete Again</button></section>
    <section id="loading-state" class="state-message" aria-label="Loading customer list"><h2>Loading customers...</h2><p>Please wait while the customer records are being loaded.</p></section>
    <section id="empty-state" class="state-message" aria-label="Empty customer list" hidden><h2>No customers yet</h2><p>There are currently no customers registered in the system.</p><a href="/customers/create" class="button">Add Customer</a></section>
    <section id="error-state" class="state-message error-state" aria-label="Customer list error" hidden><h2>Unable to load customers</h2><p id="error-message">Something went wrong while loading the customer records.</p><button id="try-again" type="button" class="button">Try Again</button></section>
    <section id="list-state" class="table-container" aria-label="Customer list" hidden><table><thead><tr><th>ID</th><th>Name</th><th>Contact Number</th><th>Actions</th></tr></thead><tbody id="customer-rows"></tbody></table></section>
</main>
<script src="/js/demo-authorization.js"></script>
<script>
const states = { loading: document.getElementById('loading-state'), empty: document.getElementById('empty-state'), error: document.getElementById('error-state'), list: document.getElementById('list-state') };
const rows = document.getElementById('customer-rows'), errorMessage = document.getElementById('error-message'), feedback = document.getElementById('action-feedback'), actionMessage = document.getElementById('action-message'), retryDelete = document.getElementById('retry-delete');
function showState(name) { Object.entries(states).forEach(([key, element]) => { element.hidden = key !== name; }); }
function cell(value) { const element = document.createElement('td'); element.textContent = value == null ? '' : String(value); return element; }
function actions(id) { const element = document.createElement('td'); element.className = 'actions'; [['View', '/customers/'], ['Edit', '/customers/edit/']].forEach(([label, path]) => { const link = document.createElement('a'); link.href = path + encodeURIComponent(String(id)); link.textContent = label; element.append(link); }); const remove = document.createElement('button'); remove.type = 'button'; remove.textContent = 'Delete'; remove.addEventListener('click', () => deleteCustomer(id, remove)); element.append(remove); return element; }
function feedbackMessage(message, canRetry, retry) { actionMessage.textContent = message; retryDelete.hidden = !canRetry; retryDelete.onclick = retry || null; feedback.hidden = false; }
function requestError(status) { if (status === 403) return 'You are not authorized to delete this customer.'; if (status === 404) return 'This customer was not found. Refresh the list and try again.'; if (status === 422) return 'The delete request was invalid.'; if (status >= 500) return 'The server could not delete this customer. Please try again.'; return 'Unable to delete this customer. Please check your connection and try again.'; }
async function deleteCustomer(id, button) { if (!window.confirm('Delete this customer? This action cannot be undone.')) return; button.disabled = true; button.textContent = 'Deleting...'; feedbackMessage('Deleting customer...', false); const retry = () => deleteCustomer(id, button); try { const response = await fetch('/api/customers/' + encodeURIComponent(String(id)), { method: 'DELETE', headers: Object.assign({ Accept: 'application/json' }, window.demoAuthorization.headersFor('customer')) }); if (!response.ok) { feedbackMessage(requestError(response.status), true, retry); return; } feedbackMessage('Customer deleted successfully.', false); await loadCustomers(); } catch (error) { feedbackMessage('Network error while deleting the customer.', true, retry); } finally { button.disabled = false; button.textContent = 'Delete'; } }
async function loadCustomers() {
    showState('loading');
    try {
        const response = await fetch('/api/customers', { headers: { Accept: 'application/json' } });
        if (!response.ok) throw new Error('The customer service returned an error.');
        const payload = await response.json();
        if (!payload || !Array.isArray(payload.data) || payload.data.some(item => !item || item.id == null)) throw new Error('The customer service returned an invalid response.');
        rows.replaceChildren();
        payload.data.forEach(customer => { const row = document.createElement('tr'); row.append(cell(customer.id), cell(customer.name), cell(customer.contact_number), actions(customer.id)); rows.append(row); });
        showState(payload.data.length ? 'list' : 'empty');
    } catch (error) { errorMessage.textContent = error instanceof Error ? error.message : 'Please try again later.'; showState('error'); }
}
document.getElementById('try-again').addEventListener('click', loadCustomers); loadCustomers();
</script>
</body>
</html>
