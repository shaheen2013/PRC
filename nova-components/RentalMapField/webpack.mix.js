let mix = require('laravel-mix');

mix.webpackConfig({
    node: {
        fs: "empty",
        tls: "empty",
        net: "empty"
    }
});

mix.setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
