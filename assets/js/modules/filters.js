jQuery( document ).ready( function( $ ) {


// avoid close dropdown on click inside
$( document ).on( 'click', '.widget .dropdown-menu', function ( e ) {
	e.stopPropagation();
});


// show/hide filter buttons
function checkEnableFilters() {
	if ( !$( '.js_form_filter form' ).length > 0 ) return;
	if ( $( '.js_form_filter form' ).children( 'input:not([name="paged"], [name="s"], [name="post_type"])' ).length > 0 ) {
		$( 'html' ).addClass( 'filtered' );
	} else {
		$( 'html' ).removeClass( 'filtered' );
		//for a case when filtered and reloaded and needs uncheck filters and apply
		if ( selected_filters.length < 1 )
			$( 'html' ).removeClass( 'filtered' );
		else
			$( 'html' ).addClass( 'filtered' );
	}
}
checkEnableFilters();


// submit all filters
$( document ).on( 'click', '.js_submit_filters', function () {
	$( '.js_form_filter form' ).submit();
});


// reset filters
$( document ).on( 'click', '.js_reset_filters', function ( e ) {
	e.preventDefault();
	$( '.js_form_filter form' ).find( 'select' ).prop( 'selectedIndex',0 );
	$( '.js_wrap_filters' ).find( '[type=checkbox]' ).prop( 'checked', false );
	$( '.js_form_filter form input:not( [name="paged"], [name="s"], [name="post_type"] )' ).remove();
	$( '.js_form_filter form' ).submit();
});


// display count of selected filters
function setCountSelectedFilter( selector ) {
	var $this         = selector;
	var countSelected = $this.find( '.js_filter_checkbox:checked' ).length;
	if ( countSelected != 0 )
		$this.closest( '.widget' ).find( '.js_count_selected_filter' ).removeClass( 'd-none' ).html( countSelected );
	else
		$this.closest( '.widget' ).find( '.js_count_selected_filter' ).addClass( 'd-none' );
	// set counter for mobile
	var allCheckedFilters = $('.js_filter_checkbox:checked').length;
	if ( allCheckedFilters > 0 )
		$('.js_all_selected_filter').removeClass( 'd-none' ).html( allCheckedFilters );
	else
		$('.js_all_selected_filter').addClass( 'd-none' );
}
$( '.js_filter_list' ).each( function() {
	setCountSelectedFilter( $( this ) );
});


// collect price filter into hidden inputs
function changePrice() {
	var min_price = $( '.price_slider_amount [name="min_price"]' ).val();
	var max_price = $( '.price_slider_amount [name="max_price"]' ).val();
	if ( !$( '.js_form_filter form' ).find( '[name="min_price"]' ).length ) {
		$( '<input type="hidden" name="min_price" value="' + min_price + '">' ).appendTo( '.js_form_filter form' );
		$( '<input type="hidden" name="max_price" value="' + max_price + '">' ).appendTo( '.js_form_filter form' );
	} else {
		$( '.js_form_filter form' ).find( '[name="min_price"]' ).val( min_price );
		$( '.js_form_filter form' ).find( '[name="max_price"]' ).val( max_price );
	}
	checkEnableFilters();
};
$( '.price_slider' ).on( 'slidestop', function() {
	changePrice();
})
$( document ).on( 'input change', '.price_slider_amount input', function () {
	changePrice();
});


// collect checkbox filters into hidden inputs
$( document ).on( 'click', '.js_filter_checkbox', function () {
	var filter_type     = ( $( this ).closest( '.js_filter_list' ).hasClass( 'query_type_or' ) ) ? 'or' : 'and';
	var filter_val      = $( this ).val();
	var filter_name     = $( this ).attr( 'name' );
	var name_query_type = ( filter_type == 'or' ) ? filter_name.replace( 'filter_', 'query_type_' ) : '';
	// add hidden inputs with value if this type of filter BEFORE click was not selected
	if ( !$( '.js_form_filter form' ).find( '[name="' + filter_name +  '"]' ).length ) {
		$( '<input type="hidden" name="' + filter_name + '" value="' + filter_val + '">' ).appendTo( '.js_form_filter form' );
		if ( filter_type == 'or' )
			$( '<input type="hidden" name="' + name_query_type + '" value="or">' ).appendTo( '.js_form_filter form' );
	} else {
	// add filter into existing hidden field - if such type filter BEFORE click was selected
		var array_filter = $( '.js_form_filter form' ).find( '[name="' + filter_name +  '"]' ).val().split( ',' );
		if ( $( this ).prop( 'checked' ) ) {
			array_filter.push( filter_val );
		} else {
			array_filter = jQuery.grep( array_filter, function( value ) {
				return value != filter_val;
			});
		}
		$( '.js_form_filter form' ).find( '[name="' + filter_name +  '"]' ).val( array_filter.toString() );
	}
	// remove hidden inputs if this type of filter AFTER click is not selected
	if ( !$( '.js_form_filter form' ).find( '[name="' + filter_name +  '"]' ).val().length ) {
		$( '.js_form_filter form' ).find( '[name="' + filter_name +  '"]' ).remove();
		if ( filter_type == 'or' )
			$( '.js_form_filter form' ).find( '[name="' + name_query_type + '"]' ).remove();
	}
	checkEnableFilters();
	var filter_list = $( this ).closest( '.js_filter_list' );
	setCountSelectedFilter( filter_list );
});


// show/hide mobile filter
$( document ).on( 'click', '.js_show_filters_btn', function( e ) {
	e.preventDefault();
	$( 'html' ).addClass( 'js_show_filters' );
});
$( document ).on( 'click', '.js_close_filters', function( e ) {
	e.preventDefault();
	$( 'html' ).removeClass( 'js_show_filters' );
});


})