export async function apiRequest(endpoint, options = {}) {
    const defaults = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': authSpace.nonce,
        },
    };

    const config = {
        ...defaults,
        ...options,
        headers: {
            ...defaults.headers,
            ...(options.headers || {}),
        },
    };

    const response = await fetch(
        authSpace.restUrl + endpoint.replace(/^\//, ''),
        config
    );

    let data = null;

    try {
        data = await response.json();
    } catch (_) {}

    if (!response.ok) {
        throw new Error(
            data?.message || `Request failed with status ${response.status}`
        );
    }

    return data;
}