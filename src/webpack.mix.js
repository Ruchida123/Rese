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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/menu.js', 'public/js')
    .js('resources/js/favorite.js', 'public/js')
    .js('resources/js/detail.js', 'public/js')
    .js('resources/js/mypage.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/review.js', 'public/js')
    .autoload({
        "jquery": [ '$', 'window.jQuery' ],
    })
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
