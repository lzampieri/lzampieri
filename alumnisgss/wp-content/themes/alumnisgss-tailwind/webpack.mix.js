const mix = require('laravel-mix');
let path = require('path');

mix.webpackConfig({
    watchOptions: {
        ignored: [
            path.posix.resolve(__dirname, './node_modules'),
            path.posix.resolve(__dirname, './assets')
        ]
    }
});

mix.setPublicPath('./')
    .js('src/app.js', 'assets')
    .postCss('src/app.css', 'assets', [
        require("tailwindcss"),
    ]);

if (mix.inProduction()) {
    mix.version();
}

if ( !mix.inProduction()) {
    mix.disableNotifications();
}
    