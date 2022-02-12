const mix = require('laravel-mix')

const {distPath, srcPath, homeUrl, assetUrl} = require('../env')

mix.setPublicPath(distPath)
    .setResourceRoot(assetUrl)
    .js(srcPath + '/js/admin.js', 'js/admin.js').vue()
    .postCss(srcPath + '/css/admin.css', 'css/admin.css', [
        require('tailwindcss')({
            config: srcPath + '/build/tailwind.config.js'
        }),
        require('autoprefixer')
    ])
    .version()
    .browserSync(homeUrl)
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.mjs$/,
                    resolve: {fullySpecified: false},
                    include: /node_modules/,
                    type: "javascript/auto"
                }
            ]
        },
    })
