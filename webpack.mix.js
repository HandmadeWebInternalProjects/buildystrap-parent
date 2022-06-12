let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.options({
    cssNano: {
        discardComments: {
            removeAll: true,
        },
    },
    terser: {
        extractComments: false,
        terserOptions: {
            output: {
                comments: false,
            },
        },
    }
});

mix.js('resources/js/frontend.js', 'dist/js/parent-script.js')
    .sass('resources/sass/frontend.scss', 'dist/css/parent-style.css')
    .sass('resources/sass/frontend-woocommerce.scss', 'dist/css/parent-style-woocommerce.css');

mix.js('resources/js/backend-builder.js', 'dist/js/backend-builder.js')
    .sass('resources/sass/backend-builder.scss', 'dist/css/backend-builder.css');
