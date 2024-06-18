const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = {
    entry: [
        "./resources/js/file-object-manager.js",
    ],
    output: {
        filename: 'file-object-manager.js',
        path: path.resolve(__dirname, './resources/dist/js'),
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()],
    },
};
