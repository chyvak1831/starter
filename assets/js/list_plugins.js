var plugins = [
	// BOOTSTRAP
	// popper.js
	'./node_modules/@popperjs/core/dist/umd/popper.min.js',

	// bootstrap base
	'./node_modules/bootstrap/js/dist/dom/data.js',
	'./node_modules/bootstrap/js/dist/dom/selector-engine.js',
	'./node_modules/bootstrap/js/dist/dom/event-handler.js',
	'./node_modules/bootstrap/js/dist/dom/manipulator.js',

	// bootstrap modules
	'./node_modules/bootstrap/js/dist/base-component.js',
	'./node_modules/bootstrap/js/dist/alert.js',
	// './node_modules/bootstrap/js/dist/button.js',
	// './node_modules/bootstrap/js/dist/carousel.js',
	'./node_modules/bootstrap/js/dist/collapse.js',
	'./node_modules/bootstrap/js/dist/dropdown.js',// require popper - should be uncommented above
	'./node_modules/bootstrap/js/dist/modal.js',
	'./node_modules/bootstrap/js/dist/offcanvas.js',
	// './node_modules/bootstrap/js/dist/popover.js',// require popper - should be uncommented above; require tooltip - should be uncommented below
	// './node_modules/bootstrap/js/dist/scrollspy.js',
	// './node_modules/bootstrap/js/dist/tab.js',
	'./node_modules/bootstrap/js/dist/toast.js',
	// './node_modules/bootstrap/js/dist/tooltip.js',// require popper - should be uncommented above
	// END BOOTSTRAP

    // slick
    './node_modules/slick-carousel/slick/slick.min.js'
];

module.exports = {
	plugins: plugins
}