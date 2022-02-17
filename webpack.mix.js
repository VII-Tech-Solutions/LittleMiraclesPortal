const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// copy images to public
mix.copyDirectory('resources/images', 'public/images');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// Sortable.js
mix.js('node_modules/sortablejs/Sortable.min.js', 'public/js')
    .sourceMaps(true, 'source-map');

// Media
mix.js('resources/js/media.js', 'public/js')
    .sourceMaps(true, 'source-map');
mix.sass('resources/sass/media.scss', 'public/css')
    .sourceMaps(true, 'source-map');

mix.copy("resources/assets", "public/assets");

mix.copy('node_modules/sweetalert2/dist/sweetalert2.min.css', 'public/css');
mix.copy('node_modules/sweetalert2/dist/sweetalert2.min.js', 'public/js');
