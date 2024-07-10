const mix = require('laravel-mix');

mix
// .js('resources/js/frontend/app.js', 'public/frontend/js')
// .js('resources/js/admin/app.js', 'public/admin/js')
.sass('resources/sass/admin/app.scss', 'public/admin/css');