const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([

    'resources/assets/css/libs/bootstrap.css',
    'resources/assets/css/libs/font-awesome.css',
    'resources/assets/css/libs/metisMenu.css',
    'resources/assets/css/libs/sb-admin-2.css',
    'resources/assets/css/libs/lightbox.css',
    'resources/assets/css/libs/select2.min.css',
    'resources/assets/css/libs/dropzone.min.css',
    'resources/assets/css/libs/pnotify.custom.min.css',
    'resources/assets/css/libs/smart_wizard.min.css',
    'resources/assets/css/libs/styles.css'

], 'public/css/libs.css');

mix.scripts([

    'resources/assets/js/libs/jquery.js',
    'resources/assets/js/libs/bootstrap.js',
    'resources/assets/js/libs/metisMenu.js',
    'resources/assets/js/libs/sb-admin-2.js',
    'resources/assets/js/libs/lightbox.js',
    'resources/assets/js/libs/select2.full.min.js',
    'resources/assets/js/libs/clipboard.min.js',
    'resources/assets/js/libs/sweetalert2.js',
    'resources/assets/js/libs/pnotify.custom.min.js',
    'resources/assets/js/libs/dropzone.js',
    'resources/assets/js/libs/jquery.smartWizard.min.js',
    'resources/assets/js/libs/scripts.js',

], 'public/js/libs.js');