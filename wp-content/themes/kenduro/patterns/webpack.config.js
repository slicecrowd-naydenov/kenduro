var path = require('path');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = {
  entry: {
    main: './main.js'
  },
  output: {
    path: path.resolve(__dirname, '../build/js'),
    filename: '[name].js'
  },
  module: {
    rules: []
  },
  stats: {
    colors: true
  },
  mode: 'none',
  devtool: 'source-map',
  optimization: {
    minimizer: [
      // В Webpack 5 и по-нови версии се използва TerserPlugin за минимизация.
      new TerserPlugin({
        extractComments: false, // Ако искате да изключите извличането на коментари.
      }),
    ],
  },
  resolve: {
    fallback: {
      stream: require.resolve('stream-browserify')
    }
  },
};