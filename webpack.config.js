var Encore = require('@symfony/webpack-encore');
const Dotenv = require('dotenv-webpack');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableSingleRuntimeChunk()
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function(options) {}, {
        resolveUrlLoader: false
    })

    .configureDefinePlugin(options => {
        let dotenv = new Dotenv({
            path: "./.env",
        })
        let vars = dotenv.gatherVariables();

        options['process.env'].EXPLORER_API = JSON.stringify(vars["BACKEND_URI"]);
    })

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
