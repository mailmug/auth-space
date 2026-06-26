const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaultConfig,
    entry: {
        index: './assets/js/index.js',
    },
    output: {
        ...defaultConfig.output,
        path: __dirname + '/assets/build',
    },
    watchOptions: {
        ignored: /assets\/build/,
    }
};