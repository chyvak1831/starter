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
		$( '.input-text' ).addClass( 'form-control' );
		$( 'select' ).addClass( 'custom-select' );
		$( '.woocommerce-form-login__submit, .woocommerce-form-register__submit, .lost_reset_password .woocommerce-Button, .wc-proceed-to-checkout .button, #place_order' ).addClass( 'btn btn-primary btn-block btn-lg' );
		$( '.woocommerce-cart-form__contents .coupon .button, .woocommerce-cart-form__contents [name="update_cart"], [name="apply_coupon"], .woocommerce-Button, [name="save_address"]' ).addClass( 'btn btn-primary' );	
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


	// subnav fix dropdown attrs
	$( '.menu-item-has-children.menu_nested_dropdown' ).children( 'a' ).attr( 'data-toggle', 'dropdown' ).attr( 'aria-expanded', 'false' );


	// make all dropdowns static
	$( '[data-toggle="dropdown"]' ).attr( 'data-display', 'static' );


	// nested dropdowns fix
	$( '.dropdown-menu [data-toggle="dropdown"]' ).on( 'click', function( e ) {
		if ( $( this ).closest( '.dropdown-menu' ).parents().eq(0).hasClass( 'menu_nested_list' ) ) {
			return;
		}
		if ( !$( this ).next().hasClass( 'show' ) ) {
			$( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( 'show' );
		}
		$( this ).attr( 'aria-expanded', function( index, attr ) {
			return attr == 'true' ? 'false' : 'true';
		});
		$( this ).siblings( '.dropdown-menu' ).toggleClass( 'show' );
		return false;
	});


	// make menu-item as collapse
	$( '.menu-item-has-children.menu_nested_collapse' ).children( 'a' ).attr( 'data-toggle', 'collapse' ).attr( 'aria-expanded', 'false' );
	$( '.menu-item-has-children.menu_nested_collapse' ).each( function() {
		var itemId = $( this ).attr( 'id' );
		$( this ).children( 'a' ).attr( 'href',  '#collapse_' + itemId );
		$( this ).children( '.sub-menu' ).attr( 'id',  'collapse_' + itemId ).addClass( 'collapse list-unstyled' ).removeClass( 'dropdown-menu' );
		$( this ).children( '.sub-menu' ).children( '.menu-item' ).children( '.dropdown-item' ).removeClass( 'dropdown-item' );
	});


	// ff svg image - width bugfix
	$( '.menu-item img[srcset$="svg"], .menu-item img[data-srcset$="svg"]' ).each(function () {
		$( this ).width( $( this ).attr( 'sizes' ) );
	})

})