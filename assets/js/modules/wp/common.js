window.addEventListener( 'load', () => {


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
		if ( 100 < window.scrollY ) {
			document.querySelector( '.scrollup' ).classList.add( 'on' );
		} else {
			document.querySelector( '.scrollup' ).classList.remove( 'on' );
		}
	})
}


// load svg icons
fetch( starter_theme.theme_url + '/assets/svg-icons.svg' )
.then( response => response.text() )
.then( body => {
	const svg = document.createElement( 'div' );
	svg.innerHTML = body;
	document.querySelector( 'body' ).appendChild( svg );
});


// check android or ios
const getMobileOperatingSystem = () => {
	const userAgentiOS = navigator.userAgent || navigator.vendor || window.opera;
	if ( /iPad|iPhone|iPod/.test( userAgentiOS ) && !window.MSStream ) {
		document.querySelector( 'html' ).classList.add( 'iOS', 'mobile' );
	}

	const userAgentAndroid = navigator.userAgent;
	if ( /Android/.test( userAgentAndroid ) ) {
		document.querySelector( 'html' ).classList.add( 'android', 'mobile' );
	}
}
getMobileOperatingSystem();


// detect if touch - fires ONLY when user made touch
window.addEventListener( 'touchstart', () => {
	document.querySelector( 'html' ).classList.add( 'touch_device' );
});


});/*end window load event*/