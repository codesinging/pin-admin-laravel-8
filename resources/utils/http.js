import axios from 'axios'
import config from '../config/http'
import state from "../store/state"
import message from "./message"

const defaultLabel = 'loading'

const http = axios.create(config)

// 设置请求状态
const setStates = config => {
    state().set(defaultLabel)

    if (config?.label) {
        state().set(config.label)
    }
}

// 恢复请求状态
const unsetState = config => {
    state().unset(defaultLabel)

    if (config?.label) {
        state().unset(config.label)
    }
}

// 控制台打印日志
const errorLog = (title, content) => {
    console.log(title, content)
}

// 提示成功信息
const showSuccess = (content, config) => {
    if (config.message || config.successMessage) {
        message.success(typeof config.successMessage === 'string' ? config.successMessage : content)
    }
}

// 提示失败信息
const showError = (content, config) => {
    if (config.message || config.errorMessage) {
        message.error(typeof config.errorMessage === 'string' ? config.errorMessage : content)
        errorLog('http config', config)
    }
}

// 初始化请求配置
const initConfig = config => {
    config = typeof config === 'string' ? {label: config} : config

    config.message = config.message ?? true
    config.successMessage = config.successMessage ?? true
    config.errorMessage = config.errorMessage ?? true
    config.catch = config.catch ?? false

    return config
}

// 请求处理
const handler = (request, config) => {
    return new Promise(((resolve, reject) => {
        request.then(res => {
            if (res.status === 200) {
                if (res?.data?.code === 0) {
                    showSuccess(res?.data?.message, config)
                    resolve(res?.data?.data)
                    return
                }
            }

            let error = `[${res?.data?.code}]${res?.data.message || res.statusText || '请求响应错误'}`

            showError(error, config)
            errorLog('http response status error', res)

            if (config.catch) {
                reject(error)
            }
        }).catch(error => {
            let content = error.status === null ? '网络或服务器连接错误' : `[${error?.status}]${error?.response?.data?.message || error?.response?.message || '请求响应错误'}`

            showError(content, config)
            errorLog('http response error', error.toJSON())

            if (config.catch) {
                reject(content)
            }
        }).finally(() => {
            unsetState(config)
        })
    }))
}

const get = (url, config = {}) => {
    config = initConfig(config)
    setStates(config)
    return handler(http.get(url, config), config)
}

const del = (url, config = {}) => {
    config = initConfig(config)
    setStates(config)
    return handler(http.delete(url, config), config)
}

const post = (url, data, config = {}) => {
    config = initConfig(config)
    setStates(config)
    return handler(http.post(url, data, config), config)
}

const put = (url, data, config = {}) => {
    config = initConfig(config)
    setStates(config)
    return handler(http.put(url, data, config), config)
}

export default {
    get,
    del,
    post,
    put,
}
