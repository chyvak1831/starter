window.addEventListener( 'load', () => {


// hide filter canvas on tablet/desktop
const hideFiltersOnDesktop = () => {
	const filterWrap = document.querySelector( '.js_filter_section' );
	if ( !filterWrap ) return;

	const filterPanel = new bootstrap.Offcanvas( filterWrap );
	const hideFilters = () => {
		if ( window.matchMedia( '(min-width:768px)' ).matches ) filterPanel.hide();
	}
	window.addEventListener( 'resize', hideFilters );
}
hideFiltersOnDesktop();


// show/hide reset filter button
const checkIfFiltered = () => {
	const inputs = document.querySelectorAll( '.js_wrap_filters .woocommerce-ordering input' );
	if ( 0 == inputs.length ) return;

	const html = document.querySelector( 'html' );
	const filters = [...inputs].filter( element => {
		if ( element['name'] != 'paged' && element['name'] != 's' && element['name'] != 'post_type' ) return element;
	});

	if ( 0 < filters.length )
		html.classList.add( 'filtered' );
	else
		html.classList.remove( 'filtered' );
}
checkIfFiltered();


// display count of selected filters
const setCountSelectedFilter = () => {
	const filterBlock = document.querySelectorAll( '.js_wrap_filters .woocommerce-widget-layered-nav-list' );
	if ( 0 == filterBlock.length ) return;

	// set filter counter for desktop
	filterBlock.forEach( element => {
		const filterLength = element.querySelectorAll( '.woocommerce-widget-layered-nav-list__item--chosen' ).length;
		const filterCounter = element.closest( '.widget' ).querySelectorAll( '.js_count_selected_filter' );
		if ( 0 < filterLength ) [...filterCounter].map( element => element.innerHTML = filterLength );
	} );

	// set filter counter for mobile
	const allFilter = document.querySelector( '.js_all_selected_filter' );
	const allFilterLength = document.querySelectorAll( '.js_wrap_filters .woocommerce-widget-layered-nav-list__item--chosen' ).length;
	if ( 0 < allFilterLength ) allFilter.innerHTML = allFilterLength;
}
setCountSelectedFilter();


// check selected filters
const markSelectedFilter = () => {
	const selectedFilters = document.querySelectorAll( '.js_wrap_filters .woocommerce-widget-layered-nav-list__item--chosen [type="checkbox"]' );
	selectedFilters.forEach( element => { element.checked = true; });
}
markSelectedFilter();


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
	const archivePage = document.querySelector( '.js_wrap_archive' );
	const filterWrapBody = document.querySelector( '.js_filter_section .offcanvas-body' );
	if ( !archivePage ) return;

	archivePage.classList.add( 'main_loading' );
	filterWrapBody.classList.add( 'main_loading' );
	if ( pushToHistory ) {
		history.pushState( null, null, currentLink );
	}
	fetch( currentLink )
		.then( response => response.text() )
		.then( body => {
			archivePage.classList.remove( 'main_loading' );
			filterWrapBody.classList.remove( 'main_loading' );
	
			// insert archive main data
			const tempContainerData = document.createElement( 'div' );
			tempContainerData.innerHTML = body;
			archivePage.innerHTML = tempContainerData.querySelector( '.js_wrap_archive' ).innerHTML;

			// insert title
			document.querySelector( 'title' ).innerHTML = tempContainerData.querySelector( 'title' ).innerHTML;

			// run all functions
			hideFiltersOnDesktop();
			checkIfFiltered();
			setCountSelectedFilter();
			markSelectedFilter();
			yoastUpdate( tempContainerData );
			googleAnalyticsUpdate( tempContainerData );
			ajaxTriggers();
		} );
}
window.addEventListener( 'popstate', () => {
	wooAjaxFilter( location.href, false );
});


const ajaxTriggers = () => {
	// ajax sort filter
	const orderby = document.querySelector( '.product_filter_sort_ajax .js_orderby' );
	if ( orderby ) {
		orderby.addEventListener( 'change', () => {
			const formData = new URLSearchParams(new FormData( document.querySelector( '.woocommerce-ordering' ) )).toString();
			const currentLink = document.querySelector( '.js_archive_url' ).value + '?' + formData;
			wooAjaxFilter( currentLink );
		} )
	}
	// NOT ajax sort - reload fallback
	const orderbyNotAjax = document.querySelector( 'body:not(.product_filter_sort_ajax) .js_orderby' );
	if ( orderbyNotAjax ) {
		orderbyNotAjax.addEventListener( 'change', () => {
			orderbyNotAjax.closest( 'form' ).submit();
		});
	}
	// ajax attribute filter
	const filterItem = document.querySelectorAll( '.product_filter_sort_ajax .js_wrap_archive .woocommerce-widget-layered-nav-list__item a' );
	filterItem.forEach( element => element.addEventListener( 'click', e => {
		e.preventDefault();
		const currentLink = e.currentTarget.getAttribute( 'href' );
		wooAjaxFilter( currentLink );
	}));
	// ajax reset filters
	const filterReset = document.querySelector( '.product_filter_sort_ajax .js_reset_filters' );
	if ( filterReset ) {
		filterReset.addEventListener( 'click', e => {
			e.preventDefault();
			const currentLink = e.currentTarget.getAttribute( 'href' );
			wooAjaxFilter( currentLink );
		});
	}
	// ajax pagination
	const filterPagination = document.querySelectorAll( '.product_pagination_ajax .js_wrap_archive .woocommerce-pagination a.page-numbers' );
	filterPagination.forEach( element => element.addEventListener( 'click', e => {
		e.preventDefault();
		const currentLink = e.currentTarget.getAttribute( 'href' );
		wooAjaxFilter( currentLink );
		const archivePage = document.querySelector( '.js_wrap_archive' );
		window.scrollTo({
			behavior: 'smooth',
			top: archivePage.offsetTop,
		});
	}));
	// init ajax price filter
	if ( window.jQuery ) {
		jQuery( document.body ).trigger( 'init_price_filter' );
	}
}
ajaxTriggers();


// ajax price filter
const changePrice = () => {
	const priceFilter = document.querySelector( '.js_wrap_price_filter' );
	if ( !priceFilter ) return;

	const formData = new URLSearchParams(new FormData( priceFilter )).toString();
	const currentLink = priceFilter.getAttribute( 'action' ) + '?' + formData;
	wooAjaxFilter( currentLink );
}
if ( window.jQuery ) {
	jQuery( document ).on( 'slidestop', '.product_filter_sort_ajax .js_wrap_archive .price_slider', () => {
		changePrice();
	})
	jQuery( document ).on( 'input change', '.product_filter_sort_ajax .js_wrap_archive .price_slider_amount input', () => {
		changePrice();
	});
}


});/*end window load event*/