const mix = require('laravel-mix')

const distPath = '__DUMMY_DIST_PATH__'
const srcPath = '__DUMMY_SRC_PATH__'
const browserSyncProxy = '__DUMMY_HOME_URL__'

mix.setPublicPath(distPath)
    .setResourceRoot('./')
    .js(srcPath + '/js/app.js', 'js/app.js').vue()
    .postCss(srcPath + '/css/app.css', 'css/app.css', [
        require('tailwindcss')({
            config: srcPath + '/build/tailwind.config.js'
        }),
        require('autoprefixer')
    ])
    .version()
    .browserSync(browserSyncProxy)
