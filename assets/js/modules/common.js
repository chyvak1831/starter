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
	var $primary_btn = '[name="apply_coupon"], [name="update_cart"], [name="apply_coupon"], [name="save_address"], [name="tinvwl-add-to-cart"], [name="tinvwl-action"]';
	var $primary_btn_lg = '.woocommerce-form-login__submit, .woocommerce-form-register__submit, .lost_reset_password .woocommerce-Button, .wc-proceed-to-checkout .button, #place_order';
	$( '.input-text' ).addClass( 'form-control' );
	$( 'select' ).addClass( 'custom-select' );
	$( $primary_btn_lg ).addClass( 'btn btn-primary btn-block btn-lg' );
	$( $primary_btn ).addClass( 'btn btn-primary' );	
}
addFormClass();
$( document.body ).on( 'updated_cart_totals updated_checkout', function() {
	addFormClass();
})


// animate label
function checkIfFormEmpty( formSelector ) {
	var val = formSelector.val();
	if ( val != '' ) {
		formSelector.addClass( 'not_empty' );
	} else {
		formSelector.removeClass( 'not_empty' );
	}
}
$( '.js_label_on_input .form-control' ).each( function() {
	checkIfFormEmpty( $( this ) );
});
$( document ).on( 'input', '.js_label_on_input .form-control', function() {
	$( this ).removeClass( 'is-invalid' );
	checkIfFormEmpty( $( this ) );
});


// fix aws accessability
$( '.aws-search-field' ).attr( 'aria-label', 'Search' );


// category pagination
function woo_ajax_pagination( currentLink, pushToHistory = false ) {
	$( '.js_archive_wrap_products' ).addClass( 'main_loading' );
	if ( pushToHistory ) {
		history.pushState( null, null, currentLink );
	}
	$.ajax({
		url: currentLink,
		success: function ( data ) {
			$( '.js_archive_wrap_products' ).removeClass( 'main_loading' );
			$( '.js_archive_wrap_products' ).html( $( data ).find( '.js_archive_wrap_products' ).html() );
		},
		error: function ( data ) {
			$( '.js_archive_wrap_products' ).removeClass( 'main_loading' );
			location.reload();
		}
	})
}
$( document ).on( 'click', '.woocommerce-pagination .page-numbers', function( e ) {
	currentLink = $( this ).attr( 'href' )
	woo_ajax_pagination( currentLink, true );
	e.stopPropagation();
	e.preventDefault();
})
window.onpopstate = function() {
	woo_ajax_pagination( location.href );
}


})