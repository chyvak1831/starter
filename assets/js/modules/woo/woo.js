window.addEventListener( 'load', () => {


// fix aws accessability
const awsField = document.querySelector( '.aws-search-field' );
if ( awsField ) {
	awsField.setAttribute( 'aria-label', 'Search' );
}


// fix form classes
const addFormClass = () => {
	const primaryBtn = '[name="apply_coupon"], [name="update_cart"], [name="apply_coupon"], [name="save_address"], [name="tinvwl-add-to-cart"], [name="tinvwl-action"], .woocommerce-Button';
	const primaryBtnLg = '.woocommerce-form-login__submit, .woocommerce-form-register__submit, .lost_reset_password .woocommerce-Button, .wc-proceed-to-checkout .button, #place_order';
	document.querySelectorAll( '.input-text' ).forEach( element => { element.classList.add( 'form-control' ) } );
	document.querySelectorAll( 'select' ).forEach( element => { element.classList.add( 'form-select' ) } );
	document.querySelectorAll( primaryBtn ).forEach( element => { element.classList.add( 'btn', 'btn-primary' ) } );
	document.querySelectorAll( primaryBtnLg ).forEach( element => { element.classList.add( 'btn', 'btn-primary', 'btn-lg' ) } );
}
addFormClass();
if ( window.jQuery ) {
	jQuery( document.body ).on( 'updated_cart_totals updated_checkout', () => {
		addFormClass();
	})
}


});/*end window load event*/