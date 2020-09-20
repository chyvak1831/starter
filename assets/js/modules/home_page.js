jQuery( document ).ready( function( $ ) {

// fullwidth carousel
function initFullCarousel() {
	$( '.js_fullwidth_carousel' ).each( function () {
		var $this = $( this );
		var prevArrow = $this.closest( '.js_wrap_fullwidth_carousel' ).find( '.js_carousel_control_prev' );
		var nextArrow = $this.closest( '.js_wrap_fullwidth_carousel' ).find( '.js_carousel_control_next' );
		new Swiper ( $this, {
			loop: true,
			navigation: {
				nextEl: nextArrow,
				prevEl: prevArrow,
			},
		});
	});
}
initFullCarousel();


// home featured-product carousel
function initProductCarousel() {
	$( '.js_product_carousel' ).each( function () {
		var $this = $( this );
		var prevArrow = $this.closest( '.js_wrap_product_carousel' ).find( '.js_carousel_control_prev' );
		var nextArrow = $this.closest( '.js_wrap_product_carousel' ).find( '.js_carousel_control_next' );
		new Swiper ( $this, {
			loop: false,
			spaceBetween: 0,
			navigation: {
				nextEl: nextArrow,
				prevEl: prevArrow,
			},
			breakpoints: {
				320: {slidesPerView: 2},
				768: {slidesPerView: 3},
				992: {slidesPerView: 4},
				1200: {slidesPerView: 5}
			}
		});
	});
}
initProductCarousel();


})