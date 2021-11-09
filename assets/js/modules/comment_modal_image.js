document.body.addEventListener( 'shown.bs.modal', e => {
	if ( e.target && !e.target.matches( '.js_comment_img_modal' ) ) return;

	// modal: thumbnail carousel
	const thumbnailCarousel = new Swiper( '.js_comment_img_modal .js_thumbnail_carousel .swiper', {
		navigation: {
			prevEl: '.js_comment_img_modal .js_thumbnail_carousel .js_carousel_control_prev',
			nextEl: '.js_comment_img_modal .js_thumbnail_carousel .js_carousel_control_next'
		},
		breakpoints: {
			1200: {slidesPerView: 6},
			992: {slidesPerView: 5},
			320: {slidesPerView: 3}
		}
	})

	// modal: main img
	new Swiper( '.js_comment_img_modal .js_img_carousel', {
		thumbs: {
			swiper: thumbnailCarousel,
		}
	})
})