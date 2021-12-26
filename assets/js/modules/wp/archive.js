window.addEventListener( 'load', () => {


// ajax update yoast
const yoastUpdate = data => {
	const yoastData = [ '.yoast-schema-graph', '[property="og:title"]', '[rel="next"]', '[rel="prev"]', '[rel="canonical"]' ];
	yoastData.forEach( element => {
		if ( document.querySelector( element ) ) {
			document.querySelector( element ).remove();
		}
		if ( data.querySelector( element ) ) {
			document.querySelector( 'title' ).after( data.querySelector( element ) );
		}
	} );
}


// send GA data - initially data MUST be updated in ga object and then send 'pageview'
const googleAnalyticsUpdate = data => {
	if ( window.ga ) {
		ga( 'set', {
			page: location.pathname,
			title: data.querySelector( 'title' ).textContent
		});
		ga( 'send', 'pageview' );
	}
}


// ajax request
const wooAjaxFilter = ( currentLink, pushToHistory = true ) => {
	const archivePage = document.querySelector( '.js_wrap_post_archive' );
	if ( !archivePage ) return;

	archivePage.classList.add( 'main_loading' );
	if ( pushToHistory ) {
		history.pushState( null, null, currentLink );
	}
	fetch( currentLink )
		.then( response => response.text() )
		.then( body => {
			archivePage.classList.remove( 'main_loading' );
	
			// insert archive main data
			const tempContainerData = document.createElement( 'div' );
			tempContainerData.innerHTML = body;
			archivePage.innerHTML = tempContainerData.querySelector( '.js_wrap_post_archive' ).innerHTML;

			// insert title
			document.querySelector( 'title' ).innerHTML = tempContainerData.querySelector( 'title' ).innerHTML;

			// run all functions
			yoastUpdate( tempContainerData );
			googleAnalyticsUpdate( tempContainerData );
			ajaxTriggers();
		} );
}
window.addEventListener( 'popstate', () => {
	wooAjaxFilter( location.href, false );
});


const ajaxTriggers = () => {
	// ajax pagination
	const filterPagination = document.querySelectorAll( '.post_ajax_pagination .js_wrap_post_archive .js_ajax_pagination a.page-numbers' );
	filterPagination.forEach( element => element.addEventListener( 'click', e => {
		e.preventDefault();
		const currentLink = e.currentTarget.getAttribute( 'href' );
		wooAjaxFilter( currentLink );
		const archivePage = document.querySelector( '.js_wrap_post_archive' );
		window.scrollTo({
			behavior: 'smooth',
			top: archivePage.offsetTop,
		});
	}));
}
ajaxTriggers();


});/*end window load event*/