const { appPath } = require('../app')

module.exports = {
  content: [
      appPath + '/pages/**/*.vue',
      appPath + '/views/**/*.blade.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
