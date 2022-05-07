const mix = require('laravel-mix');

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

 mix.sass('src/scss/login.scss', 'public/assets/css', {
    sassOptions: {
        outputStyle: 'compressed',
    },
    implementation: require('node-sass') // Switch from Dart to node-sass implementation
});

mix.options({
    terser: {
        extractComments: false,
    }
});
