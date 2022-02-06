import {createApp} from "vue";

window.createApp = (element, App) => {
    const app = createApp(App)

    app.mount(element)

    return app
}

window.createPage = (element, page, data = null) => {

    const component = require(`../pages/${page}.vue`).default

    const app = createApp(component)

    app.mixin({
        data: () => ({
            data,
        })
    })

    app.mount(element)

    return app
}
