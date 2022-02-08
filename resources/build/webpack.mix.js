const mix = require('laravel-mix')

const {distPath, srcPath, homeUrl} = require('../app')

mix.setPublicPath(distPath)
    .setResourceRoot('./')
    .js(srcPath + '/js/admin.js', 'js/admin.js').vue()
    .postCss(srcPath + '/css/admin.css', 'css/admin.css', [
        require('tailwindcss')({
            config: srcPath + '/build/tailwind.config.js'
        }),
        require('autoprefixer')
    ])
    .version()
    .browserSync(homeUrl)
