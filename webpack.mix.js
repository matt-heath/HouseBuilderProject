const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([

    'resources/assets/css/libs/bootstrap.css',
    'resources/assets/css/libs/font-awesome.css',
    'resources/assets/css/libs/metisMenu.css',
    'resources/assets/css/libs/sb-admin-2.min.css',
    'resources/assets/css/libs/lightbox.css',
    'resources/assets/css/libs/select2.min.css',
    'resources/assets/css/libs/dropzone.min.css',
    'resources/assets/css/libs/pnotify.custom.min.css',
    'resources/assets/css/libs/smart_wizard.min.css',
    'resources/assets/css/libs/styles.css',
], 'public/css/libs.css');

mix.styles([

    'resources/assets/css/libs/bootstrap.css',
    'resources/assets/css/libs/font-awesome.css',
    'resources/assets/css/libs/normalize.css',
    'resources/assets/css/libs/animate.css',
    'resources/assets/css/libs/icheck.min_all.css',
    'resources/assets/css/libs/owl.carousel.css',
    'resources/assets/css/libs/owl.theme.css',
    'resources/assets/css/libs/owl.transitions.css',
    'resources/assets/css/libs/lightslider.min.css',
    'resources/assets/css/libs/style.css',
    'resources/assets/css/libs/responsive.css'

], 'public/css/webLibs.css');

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
    'resources/assets/js/libs/validator.min.js',
    'resources/assets/js/libs/scripts.js'

], 'public/js/libs.js');

mix.scripts([

    'resources/assets/js/libs/jquery.js',
    'resources/assets/js/libs/bootstrap.js',
    'resources/assets/js/libs/bootstrap-hover-dropdown.js',
    'resources/assets/js/libs/owl.carousel.min.js',
    'resources/assets/js/libs/icheck.min.js',
    'resources/assets/js/libs/lightslider.min.js',
    'resources/assets/js/libs/wow.min.js',
    'resources/assets/js/libs/main.js'
], 'public/js/webLibs.js');