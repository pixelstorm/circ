const path = require("path"),
  MiniCssExtractPlugin = require("mini-css-extract-plugin"),
  BrowserSyncPlugin = require("browser-sync-webpack-plugin");

module.exports = {
  context: __dirname,
  entry: "./src/index.js",
  output: {
    path: path.resolve(__dirname, "public"),
    filename: "bundle.js",
  },
  mode: "development",
  devtool: "source-map",
  module: {
    rules: [
      {
        enforce: "pre",
        exclude: /node_modules/,
        test: /\.jsx$/,
        loader: "eslint-loader",
      },
      {
        test: /\.jsx?$/,
        loader: "babel-loader",
      },
      {
        test: /\.scss$/,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({ filename: "../style.css" }),
    new BrowserSyncPlugin({
      files: "**/*.php",
      proxy: "https://circ.local",
    }),
  ],
};
