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
    proxy: 'http://local.alexwp',
    host: 'http://local.alexwp',
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
  timeout: 1000000000,
  penthouse: {
    renderWaitTime: 500
  },
  dimensions: [{
    height: 812,
    width: 375
  }, {
    height: 5000,
    width: 5000
  }]
}
var criticalSrcPages = [
    {
      url: 'http://local.alexwp/404',
      css: 'css/critical/404.css'
    },
    {
      url: 'http://local.alexwp/sample-page/',
      css: 'css/critical/page.css'
    },
    {
      url: 'http://local.alexwp/support/',
      css: 'css/critical/page-support.css'
    },
    {
      url: 'http://local.alexwp',
      css: 'css/critical/page-home.css',
      include: [ /.modal/, /.slick(.*)/ ]
    },
    {
      url: 'http://local.alexwp/shop/',
      css: 'css/critical/archive-product.css',
      include: [ /.modal/, /.slick(.*)/ ]
    },
    {
      url: 'http://local.alexwp/product/beanie/',
      css: 'css/critical/single-product.css',
      include: [ /.modal/, /.slick(.*)/ ]
    },
    {
      url: 'http://local.alexwp/shop/',
      css: 'css/critical/taxonomy-product_cat.css',
      include: [ /.modal/, /.slick(.*)/ ]
    }
]

module.exports = {
    criticalSrcPages, criticalSrcPages,
    critical: critical,
    paths: paths,
    settingsAutoprefixer: settingsAutoprefixer,
    sync: sync
}