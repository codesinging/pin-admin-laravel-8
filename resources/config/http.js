import {baseUrl} from '../env'

export default {
    baseURL: baseUrl,
    timeout: 10 * 1000,
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
}
