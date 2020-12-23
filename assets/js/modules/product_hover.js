jQuery( document ).ready( function( $ ) {


var touch = false;
window.addEventListener( 'touchstart', function() {
	touch = true;
	productTouch();
});
var productTouch = function () {
	if ( touch == true ) {
		$( '.js_product' ).off( 'mouseenter mouseleave' );
		$( '.js_product' ).on( 'click', function() {
			$( '.js_product' ).removeClass( 'hover_effect' );
			$( this ).addClass( 'hover_effect' );
		  }
		);
		$( document ).click( function ( e ) {
			if ( $( e.target ).closest( '.js_product.hover_effect' ).length ) return;
			$( '.js_product' ).removeClass( 'hover_effect' );
		});
	} else if ( touch == false ) {
		$( '.js_product' ).on({
			mouseenter: function () {
				$( this ).addClass( 'hover_effect' );
			},
			mouseleave: function () {
				$( this ).removeClass( 'hover_effect' );
			}
		});
	}
};
productTouch();


})