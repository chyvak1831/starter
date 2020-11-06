jQuery( document ).ready( function( $ ) {


// fullwidth carousel
function initFullCarousel() {
	var $this = $( '.js_fullwidth_carousel' );
	var prevArrow = $this.find( '.js_carousel_control_prev' );
	var nextArrow = $this.find( '.js_carousel_control_next' );
	$this.find( '.js_carousel' ).slick({
		prevArrow: prevArrow,
		nextArrow: nextArrow,
	});
}
initFullCarousel();


// home featured-product carousel
function initProductCarousel() {
	$( '.js_product_carousel' ).each( function () {
		var $this = $( this );
		var prevArrow = $this.find( '.js_carousel_control_prev' );
		var nextArrow = $this.find( '.js_carousel_control_next' );
		$this.find( '.js_carousel' ).slick({
			infinite: false,
			prevArrow: prevArrow,
			nextArrow: nextArrow,
			slidesToScroll: 1,
			slidesToShow: 5,
			responsive: [
				{
					breakpoint: 1199,
					settings: { slidesToShow: 4 }
				},
				{
					breakpoint: 991,
					settings: { slidesToShow: 3 }
				},
				{
					breakpoint: 767,
					settings: { slidesToShow: 2 }
				}
			]
		});
	});
}
initProductCarousel();


})