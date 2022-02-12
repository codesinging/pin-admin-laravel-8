import http from "../utils/http"

export default {
    auth: {
        login: (data, config) => http.post('auth/login', data, config)
    }
}
