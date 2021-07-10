const dotenv = require('dotenv')
const fs = require('fs')
const path = require('path')
const Encore = require('@symfony/webpack-encore')
const ESLintPlugin = require('eslint-webpack-plugin')
const FaviconsPlugin = require('favicons-webpack-plugin')
const HtmlPlugin = require('html-webpack-plugin')
const StylelintPlugin = require('stylelint-webpack-plugin')
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin')

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'development')
}

Encore
  .setOutputPath('public/assets/')
  .setPublicPath('/assets')
  .addEntry('scripts/main', './assets/scripts/main.js')
  .addStyleEntry('styles/main', './assets/styles/main.scss')
  .cleanupOutputBeforeBuild()
  .splitEntryChunks()
  .enableSassLoader()
  .enablePostCssLoader()
  .enableVueLoader(() => {}, { runtimeCompilerBuild: false })
  .enableBuildNotifications()
  .enableIntegrityHashes(Encore.isProduction())
  .enableSourceMaps()
  .enableVersioning(Encore.isProduction())
  .enableSingleRuntimeChunk()
  .configureDefinePlugin(options => {
    options.__VUE_OPTIONS_API__ = true
    options.__VUE_PROD_DEVTOOLS__ = false

    options['process.env.NPM_PACKAGE_NAME'] = JSON.stringify(process.env.npm_package_name)
    options['process.env.NPM_PACKAGE_VERSION'] = JSON.stringify(process.env.npm_package_version)

    const envFiles = ['.env', '.env.local']
    envFiles.forEach(envFile => {
      const envFilePath = path.resolve(__dirname, envFile);
      if (fs.existsSync(envFilePath)) {
        const envVars = dotenv.config({ path: envFilePath }).parsed
        Object.keys(envVars).forEach(envVar => {
          options['process.env.' + envVar] = JSON.stringify(envVars[envVar])
        })
      }
    })
  })
  .addPlugin(new ESLintPlugin({
    context: 'assets',
    files: '**/*.(js|vue)'
  }))
  .addPlugin(new StylelintPlugin({
    context: 'assets',
    files: '**/*.(scss|vue)'
  }))
  .addPlugin(new FaviconsPlugin({
    logo: path.resolve(__dirname, 'assets/images/logo.svg'),
    outputPath: Encore.isProduction() ? 'favicons.[contenthash:8]/' : 'favicons/',
    prefix: Encore.isProduction() ? 'favicons.[contenthash:8]/' : 'favicons/',
    favicons: {
      icons: {
        android: {
          background: '#ffffff',
          mask: true,
          offset: 10
        },
        appleIcon: {
          background: '#ffffff',
          mask: true,
          offset: 10
        },
        appleStartup: false,
        coast: false,
        favicons: true,
        firefox: false,
        windows: false,
        yandex: false
      }
    }
  }))
  .addPlugin(new HtmlPlugin({
    filename: path.resolve(__dirname, 'public/index.html'),
    template: path.resolve(__dirname, 'assets/index.html')
  }))
  .addPlugin(new ImageMinimizerPlugin({
    minimizerOptions: {
      plugins: [
        ['gifsicle', { interlaced: true }],
        ['jpegtran', { progressive: true }],
        ['optipng', { optimizationLevel: 5 }],
        ['svgo', {
          plugins: [{
            name: 'removeViewBox',
            active: false
          }]
        }]
      ]
    }
  }))
  .addRule({
    test: /worker\.js$/i,
    loader: 'worker-loader'
  })
  .addAliases({
    '@images': path.resolve(__dirname, 'assets/images'),
    '@scripts': path.resolve(__dirname, 'assets/scripts'),
    '@styles': path.resolve(__dirname, 'assets/styles')
  })

try {
  require.resolve('@fortawesome/pro-light-svg-icons')
} catch {
  Encore.addAliases({
    '@fortawesome/pro-light-svg-icons': './polyfill/pro-light-polyfill.js'
  })
}

try {
  require.resolve('@fortawesome/pro-regular-svg-icons')
} catch {
  Encore.addAliases({
    '@fortawesome/pro-regular-svg-icons': './polyfill/pro-regular-polyfill.js'
  })
}

module.exports = Encore.getWebpackConfig()
