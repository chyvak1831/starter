// scrollto
const scrollTo = document.querySelectorAll( '.js_scrollto' );
scrollTo.forEach( element => element.addEventListener( 'click', e => {
	e.preventDefault();
	const href = e.currentTarget.getAttribute( 'href' );
	const scrollToSection = document.querySelector( href );
	window.scrollTo({
		behavior: 'smooth',
		top: scrollToSection.offsetTop,
	});
}))


// show/hide scrollup
const scrollup = document.querySelector( '.scrollup' );
if ( scrollup ) {
	window.addEventListener( 'scroll', () => {
		if ( window.scrollY > 100 ) {
			document.querySelector( '.scrollup' ).classList.add( 'on' );
		} else {
			document.querySelector( '.scrollup' ).classList.remove( 'on' );
		}
	})
}