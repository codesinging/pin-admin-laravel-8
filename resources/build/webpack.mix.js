const mix = require('laravel-mix')

const {distPath, srcPath, homeUrl} = require('../app')

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
    .browserSync(homeUrl)
