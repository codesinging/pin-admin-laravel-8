const mix = require('laravel-mix')

const config = require('./config')

mix.setPublicPath(config.distPath)
    .setResourceRoot('./')
    .js(config.srcPath + '/js/app.js', 'js/app.js').vue()
    .postCss(config.srcPath + '/css/app.css', 'css/app.css', [])
    .version()
