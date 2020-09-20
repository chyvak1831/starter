// PATH for folder/files - relative to gulpfile.js
var paths = {
  scss: 'assets/scss/',
  css: 'assets/css/',
  scripts: 'assets/js/',
  html: ''
}

// browserSync
var sync = {
  server: {
    files: ['{template-parts}/**/*.php', '*.php'],
    proxy: 'yourdomain',
    host: 'yourdomain',
    port: 4000,
    open: false,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  }
}

// autoprefixer
var settingsAutoprefixer = {
  browsers: [
    'last 2 versions'
  ]
}

// critical css
var critical = {
  base: 'assets/',
  ignore: ['@font-face',/url\(/],
  minify: true,
  timeout: 3000000,
  width: 2000,
  height: 1000
}
var criticalSrcPages = [
    {
      url: 'yourdomain',
      css: 'css/critical/home.css',
      include: [
        /.modal/,
      ]
    },
    {
      url: 'yourdomain/shop/',
      css: 'css/critical/archive-product.css',
    },
    {
      url: 'yourdomain/URLtosinglepage/',
      css: 'css/critical/single-product.css',
    }
]

module.exports = {
    criticalSrcPages, criticalSrcPages,
    critical: critical,
    paths: paths,
    settingsAutoprefixer: settingsAutoprefixer,
    sync: sync
}