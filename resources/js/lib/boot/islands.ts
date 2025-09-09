// Add CSRF token to all HTMX POST/PUT/DELETE requests
document.addEventListener('htmx:configRequest', (event: any) => {
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta?.getAttribute('content');

    if (csrfToken && !['get', 'head', 'options'].includes(event.detail.verb.toLowerCase())) {
        event.detail.headers['X-CSRF-Token'] = csrfToken;
    }
});
