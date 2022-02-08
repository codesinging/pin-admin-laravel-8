export default {
    baseURL: import.meta.env.VITE_BASE_URL,
    timeout: 10 * 1000,
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
}
