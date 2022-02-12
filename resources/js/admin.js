import {createApp} from "vue";

import ElementPlus from '../plugins/element-plus'
import {createPinia} from "pinia";

const vueApp = (element, App) => {
    const app = createApp(App)

    app.use(ElementPlus)
    app.use(createPinia())

    app.mount(element)

    return app
}

window.createApp = (element, App) => {
    return vueApp(element, App)
}

window.createPage = (element, page) => {
    let component
    try {
        component = require(`../pages/${page}.vue`).default
    } catch (e) {
        component = require(`../pages/public/404.vue`).default
    }
    return vueApp(element, component)
}
