const path = require("path");

module.exports = {
  entry: {
    app: "./src/index.js",
    roleBasedNotifications: "./src/role-based-notifications.js",
  },
  output: {
    filename: "[name].bundle.js",
    path: path.resolve(__dirname, "public/assets"),
    clean: true,
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: ["style-loader", "css-loader"],
      },
    ],
  },
  mode: "development",
};
