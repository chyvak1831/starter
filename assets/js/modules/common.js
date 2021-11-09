// scrollto
const scrollToNode = document.querySelectorAll( '.js_scrollto' );
scrollToNode.forEach( element => element.addEventListener( 'click', e => {
	e.preventDefault();
	const href = e.currentTarget.getAttribute( 'href' );
	const scrollToSection = document.querySelector( href );
	window.scrollTo({
		behavior: 'smooth',
		top: scrollToSection.offsetTop,
	});
}))


// show/hide scrollup
const scrollupNode = document.querySelector( '.scrollup' );
if ( scrollupNode ) {
	window.addEventListener( 'scroll', () => {
		if ( window.scrollY > 100 ) {
			document.querySelector( '.scrollup' ).classList.add( 'on' );
		} else {
			document.querySelector( '.scrollup' ).classList.remove( 'on' );
		}
	})
}