jQuery( document ).ready( function( $ ) {


// avoid close dropdown on click inside
$( document ).on( 'click', '.js_wrap_filters .widget .dropdown-menu', function ( e ) {
	e.stopPropagation();
});


// show/hide reset filter button
function checkIfFiltered() {
	if ( $( '.js_wrap_filters .woocommerce-ordering' ).children( 'input:not([name="paged"], [name="s"], [name="post_type"])' ).length > 0 ) {
		$( 'html' ).addClass( 'filtered' );
	} else {
		$( 'html' ).removeClass( 'filtered' );
	}
}
checkIfFiltered();


// display count of selected filters
function setCountSelectedFilter() {
	$( '.js_wrap_filters .woocommerce-widget-layered-nav-list' ).each( function() {
		var countSelected = $( this ).find( '.woocommerce-widget-layered-nav-list__item--chosen' ).length;
		if ( countSelected != 0 ) {
			$( this ).closest( '.widget' ).find( '.js_count_selected_filter' ).removeClass( 'd-none' ).html( countSelected );
		} else {
			$( this ).closest( '.widget' ).find( '.js_count_selected_filter' ).addClass( 'd-none' );
		}
		// set counter for mobile
		var allCheckedFilters = $( '.js_wrap_filters .woocommerce-widget-layered-nav-list__item--chosen' ).length;
		if ( allCheckedFilters > 0 ) {
			$('.js_all_selected_filter').removeClass( 'd-none' ).html( allCheckedFilters );
		} else {
			$('.js_all_selected_filter').addClass( 'd-none' );
		}
	} )
}
setCountSelectedFilter();


// show/hide mobile filter button
$( document ).on( 'click', '.js_show_filters_btn', function( e ) {
	e.preventDefault();
	$( 'html' ).addClass( 'js_show_filters' );
});
$( document ).on( 'click', '.js_close_filters', function( e ) {
	e.preventDefault();
	$( 'html' ).removeClass( 'js_show_filters' );
});


// check selected filters
function markSelectedFilter() {
	$( '.js_wrap_filters .woocommerce-widget-layered-nav-list__item--chosen' ).each( function() {
		$( this ).find( '.custom-control-input' ).prop( 'checked', true );
	});
}
markSelectedFilter();


// ajax update yoast
function yoastAjaxUpdate( data ) {
	$( '[rel="canonical"], [rel="prev"], [rel="next"], [property="og:title"], .yoast-schema-graph' ).remove();
	$( 'title' ).after(
		$( data ).filter( '[rel="canonical"]' ),
		$( data ).filter( '[rel="prev"]' ),
		$( data ).filter( '[rel="next"]' ),
		$( data ).filter( '[property="og:title"]' ),
		$( data ).filter( '.yoast-schema-graph' )
	);
}


// ajax request
function woo_ajax_filter( currentLink, pushToHistory = false ) {
	if ( !$( '.js_wrap_archive' ).length ) {
		return;
	}
	$( '.js_wrap_archive' ).addClass( 'main_loading' );
	if ( pushToHistory ) {
		history.pushState( null, null, currentLink );
	}
	$.ajax({
		url: currentLink,
		success: function ( data ) {
			$( '.js_wrap_archive' ).removeClass( 'main_loading' );
			$( '.js_wrap_archive' ).html( $( data ).find( '.js_wrap_archive' ).html() );// update data
			$( 'title' ).html( $( data ).filter( 'title' ).text() );// update title
			checkIfFiltered();
			setCountSelectedFilter();
			markSelectedFilter();
			$.get( $( '.js_price_slider_file' ).val() );// get price script to reinit jquery UI price slider
			yoastAjaxUpdate( data ); // update yoast plugin data
			// google analytics update
			if( window.ga ) {
				ga( 'set', {
					page: location.pathname,
					title: $( data ).filter( 'title' ).text()
				});
				ga( 'send', 'pageview' );
			}
			// END google analytics update
			
		},
		error: function ( data ) {
			$( '.js_wrap_archive' ).removeClass( 'main_loading' );
			location.reload();
		}
	})
}
window.onpopstate = function() {
	woo_ajax_filter( location.href );
}


// ajax sort filter
$( document ).on( 'change', '.product_filter_sort_ajax .js_orderby', function () {
	sortFormData = $( '.woocommerce-ordering' ).serialize();
	currentLink = $( '.js_archive_url' ).val() + '?' + sortFormData;
	woo_ajax_filter( currentLink, true );
});
// NOT ajax sort - reload fallback
$( document ).on( 'change', 'body:not(.product_filter_sort_ajax) .js_orderby', function () {
	$( this ).closest( 'form' ).submit();
});


// ajax price filter
function changePrice() {
	priceFormData = $( '.js_wrap_price_filter' ).serialize();
	currentLink = $( '.js_wrap_price_filter' ).attr( 'action' ) + '?' + priceFormData;
	woo_ajax_filter( currentLink, true );
};
$( document ).on( 'slidestop', '.product_filter_sort_ajax .js_wrap_archive .price_slider', function() {
	changePrice();
})
$( document ).on( 'input change', '.product_filter_sort_ajax .js_wrap_archive .price_slider_amount input', function () {
	changePrice();
});


// ajax attribute filter
$( document ).on( 'click', '.product_filter_sort_ajax .js_wrap_archive .woocommerce-widget-layered-nav-list__item a', function( e ) {
	e.preventDefault();
	currentLink = $( this ).attr( 'href' );
	woo_ajax_filter( currentLink, true );
	e.stopPropagation();
})


// ajax reset filters
$( document ).on( 'click', '.product_filter_sort_ajax .js_reset_filters', function ( e ) {
	e.preventDefault();
	currentLink = $( this ).attr( 'href' );
	woo_ajax_filter( currentLink, true );
});


// ajax pagination
$( document ).on( 'click', '.product_pagination_ajax .js_wrap_archive .woocommerce-pagination .page-numbers', function( e ) {
	e.preventDefault();
	currentLink = $( this ).attr( 'href' );
	woo_ajax_filter( currentLink, true );
	var wrapArchive = $( '.js_wrap_archive' ).offset().top;
	$( 'body, html' ).animate( { scrollTop: wrapArchive }, 500 );
	e.stopPropagation();
})



})