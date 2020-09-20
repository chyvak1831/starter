jQuery( document ).ready( function( $ ) {


function stepNav() {
	$( '.js_step_nav .menu-item a' ).append( '<svg aria-hidden="true" role="img"><use href="#icon-arrow_left" xlink:href="#icon-arrow_left"></use></svg>' );
	var currentLink = $( '.js_step_nav .current-menu-item' );
	var parentSubNav = currentLink.closest( '.current-menu-parent' );
	if ( currentLink.is( ':first-child' ) && currentLink.is( ':last-child' ) ) {
		parentSubNav.prev()
					.addClass( 'show_parent' )
					.find( 'li:last-child' )
					.addClass( 'prev_page' );
		parentSubNav.next()
					.addClass( 'show_parent' )
					.find( 'li:first-child' )
					.addClass( 'next_page' );
	} else if ( currentLink.is( ':first-child' ) ) {
		parentSubNav.addClass( 'show_parent' )
					.prev().addClass( 'show_parent' )
					.find( 'li:last-child' )
					.addClass( 'prev_page' );
		currentLink.next().addClass( 'next_page' );
	} else if ( currentLink.is( ':last-child' ) ) {
		currentLink.prev().addClass( 'prev_page' );
		parentSubNav.addClass( 'show_parent' )
					.next().addClass( 'show_parent' )
					.find( 'li:first-child' )
					.addClass( 'next_page' );
	} else {
		parentSubNav.addClass( 'show_parent' );
		currentLink.prev().addClass( 'prev_page' );
		currentLink.next().addClass( 'next_page' );
	}
}
stepNav();


})