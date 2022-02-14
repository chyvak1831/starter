const fs = require( 'fs' );

// PATH for folder/files - relative to gulpfile.js
const paths = {
	scss: 'assets/scss/',
	css: 'assets/css/',
	scripts: 'assets/js/',
	html: '',
	domain: 'yourdomain' // your local domain, e.g. http://local.mysite; required for local development (browserSync) and for generate critical CSS
}

// browserSync
const sync = {
	server: {
		files: [ '{template-parts}/**/*.php', '*.php' ],
		proxy: paths.domain,
		host: paths.domain,
		port: 4000,
		open: false,
		snippetOptions: {
			whitelist: [ '/wp-admin/admin-ajax.php' ],
			blacklist: [ '/wp-admin/**' ]
		}
	}
}

// autoprefixer
const settingsAutoprefixer = {
	browsers: [ 'last 2 versions' ]
}

// critical css
const sourceCssForCritical = [];//array of css files which used for create critical css
const mainCssFile = 'assets/css/starter.css';//main css file
const advancedWooSearch = '../../plugins/advanced-woo-search/assets/css/common.css';//search css plugin's file

sourceCssForCritical.push( mainCssFile );
if ( fs.existsSync( advancedWooSearch ) ) {//add search file if plugin exist
	sourceCssForCritical.push( advancedWooSearch );
}
const critical = {
	base: 'assets/',
	ignore: [ '@font-face',/url\(/ ],
	css: sourceCssForCritical,
	penthouse: {
		timeout: 1000000000,
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
// pairs URL of page - template name
const criticalSrcPages = [
	{
		url: paths.domain + '/sample-page',
		css: 'css/critical/page.css'
	},
	{
		url: paths.domain + '/support/',
		css: 'css/critical/page-support.css'
	},
	{
		url: paths.domain,
		css: 'css/critical/page-home.css'
	},
	{
		url: paths.domain,
		css: 'css/critical/index.css'
	},
	{
		url: paths.domain,
		css: 'css/critical/404.css'
	},
	{
		url: paths.domain + '/shop/',
		css: 'css/critical/archive-product.css'
	},
	{
		url: paths.domain + '/product/beanie/',
		css: 'css/critical/single-product.css'
	},
	{
		url: paths.domain + '/shop/',
		css: 'css/critical/taxonomy-product-cat.css'
	}
]

module.exports = {
	paths: paths,
	sync: sync,
	settingsAutoprefixer: settingsAutoprefixer,
	critical: critical,
	criticalSrcPages, criticalSrcPages
}