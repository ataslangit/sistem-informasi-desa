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
const resourcesAssets = 'src/';
const dest = 'public/assets/';

mix.sass(resourcesAssets + 'scss/login.scss', dest + 'css', {
    sassOptions: {
        outputStyle: 'compressed',
    },
    implementation: require('node-sass') // Switch from Dart to node-sass implementation
});

mix.options({
    processCssUrls: false,
    terser: {
        extractComments: false,
    }
});
