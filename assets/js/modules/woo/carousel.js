// homepage: fullwidth carousel
new Swiper( '.js_fullwidth_carousel .swiper', {
	navigation: {
		prevEl: '.js_fullwidth_carousel .js_carousel_control_prev',
		nextEl: '.js_fullwidth_carousel .js_carousel_control_next'
	},
	loop: true
})


// homepage, single page: product carousel
const productCarousels = document.querySelectorAll( '.js_product_carousel' );
productCarousels.forEach( element => {
	new Swiper( element.querySelector( '.swiper' ), {
		navigation: {
			prevEl: element.querySelector( '.js_carousel_control_prev' ),
			nextEl: element.querySelector( '.js_carousel_control_next' )
		},
		breakpoints: {
			1200: {slidesPerView: 5},
			992: {slidesPerView: 4},
			768: {slidesPerView: 3},
			320: {slidesPerView: 2}
		}
	})
})


// single product: thumbnail carousel under main img
const mainImgThumbnailCarousel = new Swiper( '.js_singlepage_thumbnail_carousel .swiper', {
	navigation: {
		prevEl: '.js_singlepage_thumbnail_carousel .js_carousel_control_prev',
		nextEl: '.js_singlepage_thumbnail_carousel .js_carousel_control_next'
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


// single product: main img modal carousel
document.body.addEventListener( 'shown.bs.modal', e => {
	if ( e.target && !e.target.matches( '.js_singlepage_img_modal' ) ) return;

	// modal: thumbnail carousel
	const thumbnailCarousel = new Swiper( '.js_singlepage_img_modal .js_thumbnail_carousel .swiper', {
		navigation: {
			prevEl: '.js_singlepage_img_modal .js_thumbnail_carousel .js_carousel_control_prev',
			nextEl: '.js_singlepage_img_modal .js_thumbnail_carousel .js_carousel_control_next'
		},
		breakpoints: {
			1200: {slidesPerView: 6},
			992: {slidesPerView: 5},
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