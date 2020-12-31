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
  css: [
        'assets/css/plugins.css',
        'assets/css/styles.css',
        '../../plugins/advanced-woo-search/assets/css/common.css'
       ],
  penthouse: {
    timeout: 1000000000,
  },
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
      url: 'yourdomain/sample-page/',
      css: 'css/critical/page.css'
    },
    {
      url: 'yourdomain/support/',
      css: 'css/critical/page-support.css'
    },
    {
      url: 'yourdomain',
      css: 'css/critical/page-home.css',
      include: [ /.modal/, /.slick(.*)/ ]
    },
    {
      url: 'yourdomain',
      css: 'css/critical/index.css',
      include: [ /.modal/, /.slick(.*)/ ]
    },
    {
      url: 'yourdomain',
      css: 'css/critical/404.css'
    },
    {
      url: 'yourdomain/shop/',
      css: 'css/critical/archive-product.css',
      include: [ /.modal/, /.slick(.*)/ ]
    },
    {
      url: 'yourdomain/product/beanie/',
      css: 'css/critical/single-product.css',
      include: [ /.modal/, /.slick(.*)/ ]
    },
    {
      url: 'yourdomain/shop/',
      css: 'css/critical/taxonomy-product-cat.css',
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