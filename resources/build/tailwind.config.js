const { srcPath } = require('../env')

module.exports = {
  content: [
      srcPath + '/pages/**/*.vue',
      srcPath + '/views/**/*.blade.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
