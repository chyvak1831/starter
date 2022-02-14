window.addEventListener( 'load', () => {


// zoom product page
const zoomImage = () => {
	const zoomWrap = document.querySelector( '.js_zoom_wrap' );
	if ( !zoomWrap ) return;

	// mouseover
	zoomWrap.addEventListener( 'mouseover', e => {
		e.currentTarget.querySelector( '.swiper-slide-active' ).classList.add( 'zoomOn' );
	})

	// mouseout
	zoomWrap.addEventListener( 'mouseout', e => {
		e.currentTarget.querySelector( '.swiper-slide-active' ).classList.remove( 'zoomOn' );
	})

	// mousemove
	zoomWrap.addEventListener( 'mousemove', e => {
		const rect = e.currentTarget.getBoundingClientRect();
		const x = e.clientX - rect.left;
		const y = e.clientY - rect.top;
		position = ( x / zoomWrap.offsetWidth ) * 100 + '% ' + ( y / zoomWrap.offsetHeight ) * 100 +'%';
		e.currentTarget.querySelector( '.swiper-slide-active' ).style.backgroundPosition = position;
	})
}
zoomImage();


// plus/minus product
const plusMinusProduct = () => {
	const btn = document.querySelectorAll( '.js_count_add_product [data-count]' );
	btn.forEach( element => element.addEventListener( 'click', e => {
		e.preventDefault();

		const btnType = e.currentTarget.getAttribute( 'data-count' );
		const input = e.currentTarget.closest( '.js_count_add_product' ).querySelector( '[type="number"]' );
		let currentValue = +input.value;
		const newValue = {}

		// count new value
		if ( 'minus' == btnType ) {
			if ( currentValue < 2 ) return;
			newValue.amount = --currentValue;
		} else {
			newValue.amount = ++currentValue;
		}

		// set new value to input and button 'add to cart'
		input.value = newValue.amount;
		document.querySelector( '.js_add_to_cart_btn' ).setAttribute( 'data-quantity', newValue.amount );
	}))
}
plusMinusProduct();


});/*end window load event*/