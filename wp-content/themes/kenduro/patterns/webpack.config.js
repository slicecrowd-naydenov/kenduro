var path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

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
  mode: 'production',
  devtool: 'source-map',
  optimization: {
    minimize: true, // Ensure minimization is enabled
    minimizer: [
      new TerserPlugin({
        extractComments: false,
      }),
    ]
  },
  resolve: {
    fallback: {
      stream: require.resolve('stream-browserify')
    }
  },
  // plugins: [
  //   //...
  //   new BundleAnalyzerPlugin()
  // ],
  externals: {
    jquery: 'jQuery'
  }
};