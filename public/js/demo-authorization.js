/* Demo-only authorization headers; backend authorization remains required. */
window.demoAuthorization = {
    headersFor: function (resource, context) {
        const headers = {};
        const details = context || {};

        if (resource === 'customer') headers['X-User-Role'] = 'admin';
        if (resource === 'product') headers['X-User-Role'] = 'manager';
        if (resource === 'delivery') headers['X-User-Role'] = 'dispatcher';
        if (resource === 'order' && details.customerId !== undefined
            && details.customerId !== null && String(details.customerId) !== '') {
            headers['X-User-Id'] = String(details.customerId);
        }

        return headers;
    }
};
