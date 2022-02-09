import ElementPlus from 'element-plus'
import config from '../config/element-plus'
import 'element-plus/dist/index.css'

export default {
    install: app => {
        app.use(ElementPlus, config)
    }
}
