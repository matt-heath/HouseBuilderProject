var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
        .styles([

            'libs/blog-post.css',
            'libs/bootstrap.css',
            'libs/font-awesome.css',
            'libs/metisMenu.css',
            // 'libs/dataTables.css',
            // 'libs/dataTables.responsive.css',
            'libs/sb-admin-2.css',
            'libs/lightbox.css',
            'libs/select2.min.css',
            'libs/dropzone.min.css',
            'libs/pnotify.custom.min.css',
            'libs/styles.css'

        ], './public/css/libs.css')

        .scripts([
            'libs/jquery.js',
            'libs/bootstrap.js',
            'libs/metisMenu.js',
            'libs/sb-admin-2.js',
            'libs/lightbox.js',
            'libs/select2.full.min.js',
            'libs/clipboard.min.js',
            'libs/sweetalert2.js',
            'libs/pnotify.custom.min.js',
            'libs/dropzone.js',
            'libs/scripts.js'

        ], './public/js/libs.js')
});
