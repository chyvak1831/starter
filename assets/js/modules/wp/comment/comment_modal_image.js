window.addEventListener( 'load', () => {


// load comment image modal
const loadCommentImgModal = () => {
	const comment_list = document.querySelector( '.js_comment_list' );
	if ( !comment_list ) return;

	comment_list.addEventListener( 'click', e => {
		e.preventDefault();
		if ( e.target && !e.target.matches( '.js_comment_img_modal_btn img' ) ) return;

		document.querySelector( '.main_wrap' ).classList.add( 'main_loading' );

		// collect data
		const comment_id = e.target.closest( '.js_comment_item' ).getAttribute( 'data-comment_id' );
		const data = new FormData();
		data.append( 'action', 'comment_image' );
		data.append( 'comment_id', comment_id );

		// send data
		fetch( starter_theme.ajax_url, {
			method: 'post',
			body: data
		})
		.then( response => response.text() )
		.then( body => {
			document.querySelector( '.main_wrap' ).classList.remove( 'main_loading' );

			// insert and call modal
			document.querySelector( '.main_wrap' ).insertAdjacentHTML( 'beforeend', body );
			const commentImgModal = document.querySelector( '.js_comment_img_modal' );
			new bootstrap.Modal( commentImgModal ).show();

			// remove modal when hidden
			commentImgModal.addEventListener( 'hidden.bs.modal', () => {
				commentImgModal.remove();
			})
		})
	})
}
loadCommentImgModal();


// shown comment image modal
document.body.addEventListener( 'shown.bs.modal', e => {
	if ( e.target && !e.target.matches( '.js_comment_img_modal' ) ) return;

	// modal: thumbnail carousel
	const thumbnailCarousel = new Swiper( '.js_comment_img_modal .js_thumbnail_carousel .swiper', {
		navigation: {
			prevEl: '.js_comment_img_modal .carousel_control_prev',
			nextEl: '.js_comment_img_modal .carousel_control_next'
		},
		breakpoints: {
			768: {slidesPerView: 6},
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


});/*end window load event*/