window.addEventListener( 'load', () => {


// homepage: fullwidth carousel
const fullwidthCarousel = document.querySelectorAll( '.js_fullwidth_carousel' );
fullwidthCarousel.forEach( element => {
	new Swiper( element.querySelector( '.swiper' ), {
		navigation: {
			prevEl: element.querySelector( '.carousel_control_prev' ),
			nextEl: element.querySelector( '.carousel_control_next' )
		},
		loop: true
	})
})


// homepage, single page: product carousel
const productCarousels = document.querySelectorAll( '.js_product_carousel' );
productCarousels.forEach( element => {
	new Swiper( element.querySelector( '.swiper' ), {
		navigation: {
			prevEl: element.querySelector( '.carousel_control_prev' ),
			nextEl: element.querySelector( '.carousel_control_next' )
		},
		breakpoints: {
			1200: {slidesPerView: 5},
			992: {slidesPerView: 4},
			768: {slidesPerView: 3},
			320: {slidesPerView: 2}
		},
		spaceBetween: 20,
	})
})


// single product: thumbnail carousel under main img
const singleThumbCarousel = document.querySelector( '.js_singlepage_thumbnail_carousel .swiper' );
if ( singleThumbCarousel ) {
	const mainImgThumbnailCarousel = new Swiper( singleThumbCarousel, {
		navigation: {
			prevEl: '.js_singlepage_thumbnail_carousel .carousel_control_prev',
			nextEl: '.js_singlepage_thumbnail_carousel .carousel_control_next'
		},
		breakpoints: {
			1200: {slidesPerView: 6},
			992: {slidesPerView: 5},
			320: {slidesPerView: 3}
		}
	})

	// single product: main img
	new Swiper( '.js_singlepage_img_carousel', {
		thumbs: {
			swiper: mainImgThumbnailCarousel,
		}
	})
}


// single product: main img modal carousel
document.body.addEventListener( 'shown.bs.modal', e => {
	if ( e.target && !e.target.matches( '.js_singlepage_img_modal' ) ) return;

	// modal: thumbnail carousel
	const thumbnailCarousel = new Swiper( '.js_singlepage_img_modal .js_thumbnail_carousel .swiper', {
		navigation: {
			prevEl: '.js_singlepage_img_modal .carousel_control_prev',
			nextEl: '.js_singlepage_img_modal .carousel_control_next'
		},
		breakpoints: {
			768: {slidesPerView: 6},
			320: {slidesPerView: 3}
		}
	})

	// modal: main img
	new Swiper( '.js_singlepage_img_modal .js_img_carousel', {
		thumbs: {
			swiper: thumbnailCarousel,
		}
	})
})


});/*end window load event*/