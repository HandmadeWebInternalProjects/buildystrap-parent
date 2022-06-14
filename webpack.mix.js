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

mix.js('resources/js/frontend.js', 'public/js/parent-script.js')
    .sass('resources/sass/frontend.scss', 'public/css/parent-style.css')
    .sass('resources/sass/frontend-woocommerce.scss', 'public/css/parent-style-woocommerce.css');

mix.copyDirectory('backend-editor/gui/dist/images', 'public/images');

mix.copy('backend-editor/gui/dist/style.css', 'public/css/buildy-editor.css');

// mix.copy('backend-editor/gui/dist/script.umd.js', 'public/css/buildy-editor.js');
mix.copy('backend-editor/gui/dist/script.es.js', 'public/js/buildy-editor.js');
