jQuery( document ).ready( function( $ ) {


var touch = false;
window.addEventListener( 'touchstart', function() {
	touch = true;
	productTouch();
});
var productTouch = function () {
	if ( true == touch ) {
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
	} else if ( false == touch ) {
		$( document ).on( 'mouseenter', '.js_product', function( e ) {
			$( this ).addClass( 'hover_effect' );
		})
		$( document ).on( 'mouseleave', '.js_product', function( e ) {
			$( this ).removeClass( 'hover_effect' );
		})
	}
};
productTouch();


})