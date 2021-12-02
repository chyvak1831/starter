window.addEventListener( 'load', () => {


// add attribute data-bs-toggle & data-bs-display='static' for dropdown link
const dropdown = document.querySelectorAll( '.menu .dropdown' );
dropdown.forEach( element => {
	for ( let i = 0; i < element.children.length; i++ ) {
		if ( element.children[i].tagName == 'A' ) {
			element.children[i].setAttribute( 'data-bs-toggle', 'dropdown' );
			element.children[i].setAttribute( 'data-bs-display', 'static' );
			element.children[i].setAttribute( 'data-bs-auto-close', 'outside' );
		}
	}
})


});/*end window load event*/