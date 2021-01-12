jQuery( document ).ready( function( $ ) {


// subnav fix dropdown attrs
$( '.menu-item-has-children.menu_nested_dropdown' ).children( 'a' ).attr( 'data-toggle', 'dropdown' ).attr( 'aria-expanded', 'false' );


// make all dropdowns static
$( '[data-toggle="dropdown"]' ).attr( 'data-display', 'static' );


// nested dropdowns fix
$( '.dropdown-menu [data-toggle="dropdown"]' ).on( 'click', function( e ) {
	if ( $( this ).closest( '.dropdown-menu' ).parents().eq(0).hasClass( 'menu_nested_list' ) ) {
		return;
	}
	if ( $( this ).next().hasClass( 'show' ) ) {
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


$( document ).on( 'shown.bs.dropdown', '.menu .dropdown-menu', function() {
	$( this ).parents( '.menu-item' ).addClass( 'opened_menu_dropdown' );
})
$( document ).on( 'hidden.bs.dropdown', '.menu .dropdown-menu', function() {
	$( this ).parents( '.menu-item' ).removeClass( 'opened_menu_dropdown' );
})


})