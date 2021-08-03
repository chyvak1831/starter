jQuery( document ).ready( function( $ ) {


// scrollto
$( document ).on( 'click', '.js_scrollto', function ( e ) {
	e.preventDefault();
	var id  = $( this ).attr( 'href' );
	var top = $( id ).offset().top;
	$( 'body, html' ).animate( { scrollTop: top }, 500 );
});


// scrollup
$( window ).scroll( function() {
	if ( $( this ).scrollTop() > 100 ) {
		$( '.scrollup' ).addClass( 'on' );
	} else {
		$( '.scrollup' ).removeClass( 'on' );
	}
});


// fix form classes
function addFormClass() {
	var $primary_btn = '[name="apply_coupon"], [name="update_cart"], [name="apply_coupon"], [name="save_address"], [name="tinvwl-add-to-cart"], [name="tinvwl-action"], .woocommerce-Button';
	var $primary_btn_lg = '.woocommerce-form-login__submit, .woocommerce-form-register__submit, .lost_reset_password .woocommerce-Button, .wc-proceed-to-checkout .button, #place_order';
	$( '.input-text' ).addClass( 'form-control' );
	$( 'select' ).addClass( 'form-select' );
	$( $primary_btn_lg ).addClass( 'btn btn-primary btn-lg' );
	$( $primary_btn ).addClass( 'btn btn-primary' );	
}
addFormClass();
$( document.body ).on( 'updated_cart_totals updated_checkout', function() {
	addFormClass();
})


// fix aws accessability
$( '.aws-search-field' ).attr( 'aria-label', 'Search' );


})