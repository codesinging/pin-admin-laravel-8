const { appPath } = require('../env')

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
