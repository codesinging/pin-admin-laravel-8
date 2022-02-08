import {createApp} from "vue";

import ElementPlus from './plugins/element-plus'

window.createApp = (element, App) => {
    const app = createApp(App)

    app.use(ElementPlus)

    app.mount(element)

    return app
}

window.createPage = (element, page, data = null) => {

    const component = require(`../pages/${page}.vue`).default

    const app = createApp(component)

    app.use(ElementPlus)

    app.mixin({
        data: () => ({
            data,
        })
    })

    app.mount(element)

    return app
}
