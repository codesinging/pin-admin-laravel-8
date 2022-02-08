import axios from "axios"
import config from '../config/http'
import useState from "../store/state"
import message from "./message"

const defaultLabel = 'loading'

const state = useState()

const http = axios.create(config)

http.interceptors.request.use(
    config => {
        state.set(defaultLabel)

        if (config?.label) {
            state.set(config.label)
        }

        return config
    },
    error => {
        console.log('http.request.error', error)
        message.error('发送网络请求错误')
    }
)

http.interceptors.response.use(
    response => {
        state.unset(defaultLabel)

        if (response?.config?.label) {
            state.unset(response.config.label)
        }

        if (response.status === 200) {
            if (response.data.code === 0) {
                if (response?.config?.message !== false && response?.data?.message) {
                    message.success(response?.config?.message || response.data.message())
                }
                if (response.data.data !== undefined) {
                    return response.data.data
                }
            }
        }

        message.error(`[${response.data.code}]${response.data.message || response.statusText || '请求响应错误'}`)
        console.log('http.response.error', response)

        if (response?.config?.catch) {
            return Promise.reject(response)
        }
    },
    error => {
        error = error.toJSON()

        state.unset(defaultLabel)

        if (error.config?.label) {
            state.unset(error.config.label)
        }

        console.log('http.response.status.error', error)

        if (error.config.message !== false) {
            if (err.status === null) {
                message.error('网络或服务器连接错误')
            } else {
                message.error(`[${error.status}]请求响应状态异常`)
            }
        }
        if (error.config.catch) {
            return Promise.reject(error)
        }
    }
)

export default http
