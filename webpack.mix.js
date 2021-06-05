

let mix = require('laravel-mix');
require('laravel-mix-purgecss');
let purgecssWordpress = require('purgecss-with-wordpress');

mix.sass('sass/theme.scss', 'css/theme.min.css')
    .purgeCss({
        content: ['**/*.js', '**/*.php', 'sass/understrap/woocommerce.scss'],
        safelist: [
            ...purgecssWordpress.safelist,
            'woocommerce',
            /^woocommerce/,
            /^woocommerce$/,
            /^btn$/,
        ]
    });
/*
mix.js([
    'node_modules/popper.js/dist/popper.min.js',
    // Bootstrap files, only import the JavaScript you need. 
    'node_modules/bootstrap/js/dist/alert',
    'node_modules/bootstrap/js/dist/button',
    'node_modules/bootstrap/js/dist/carousel',
    'node_modules/bootstrap/js/dist/collapse',
    'node_modules/bootstrap/js/dist/dropdown',
    'node_modules/bootstrap/js/dist/modal',
    'node_modules/bootstrap/js/dist/popover',
    'node_modules/bootstrap/js/dist/scrollspy',
    'node_modules/bootstrap/js/dist/tab',
    'node_modules/bootstrap/js/dist/toast',
    'node_modules/bootstrap/js/dist/tooltip',
    // Other JS-files.
    'node_modules/smartmenus/dist/jquery.smartmenus.min.js',
    'node_modules/smartmenus/dist/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.min.js',
    'src/js/skip-link-focus-fix.js',
    'src/js/custom-javascript.js'
    ], 'js/theme.min.js').sourceMaps();
*/