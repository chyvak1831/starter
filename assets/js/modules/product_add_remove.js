jQuery( document ).ready( function( $ ) {

// function for parse if product existing in cart
function getDataProductFragments() {
	var data = [];
	var wc_fragments = $.parseJSON( sessionStorage.getItem( wc_cart_fragments_params.fragment_name ) ),
		cart_hash    = sessionStorage.getItem( wc_cart_fragments_params.cart_hash_key ),
		cookie_hash  = Cookies.get( 'woocommerce_cart_hash');
	if ( cart_hash === null || cart_hash === undefined || cart_hash === '' ) { cart_hash = ''; }
	if ( cookie_hash === null || cookie_hash === undefined || cookie_hash === '' ) { cookie_hash = ''; }

	if ( wc_fragments && wc_fragments['div.widget_shopping_cart_content'] && cart_hash === cookie_hash ) {
		$.each( wc_fragments, function( key, value ) {
			var template = $( value );
			template.find( '.remove_from_cart_button' ).each( function() {
				var $this = $( this );
				data.push({
					id: $this.attr( 'data-product_id' ),
					href: $this.attr( 'href' ),
					cart_item_key: $this.attr( 'data-cart_item_key' )
				});
			});
		});
	}
	return data;
}

// funciton added product
function checkAddedProduct() {
	var data_products_fragments = getDataProductFragments();
	data_products_fragments.forEach( function( elem ) {
		var btn = $( '.add_to_cart_button[data-product_id="' + elem.id + '"]' );
		btn.removeClass( 'add_to_cart_button ajax_add_to_cart' )
		   .addClass( 'remove_from_cart_button added' )
		   .attr({
				'href': elem.href,
				'data-cart_item_key': elem.cart_item_key
		   });
	});
}
// call added product function on load page and on 'added_to_cart' event
checkAddedProduct();
$( document.body ).on( 'added_to_cart', function() {
	checkAddedProduct();
});

// update button status when removing/removed product from cart
$( document.body ).on( 'click', '.remove_from_cart_button', function() {
	$( this ).addClass( 'loading' );
});
$( document.body ).on( 'removed_from_cart', function() {
	var data_products_fragments = getDataProductFragments();
	$( '.js_product .remove_from_cart_button' ).each( function() {
		var $this = $( this );
		if ( data_products_fragments.some( product => product.id == $this.attr( 'data-product_id' ) ) ) return;
		$this.removeClass( 'remove_from_cart_button added loading' )
			 .addClass( 'add_to_cart_button ajax_add_to_cart' )
			 .removeAttr( 'data-cart_item_key' )
			 .attr( 'href', '?add-to-cart=' + $this.attr( 'data-product_id' ) );
	});
});


})