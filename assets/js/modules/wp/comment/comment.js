import './comment_modal_image.js';
import './fileuploader.js';

// validate simple fields (name, email, comment, privacy)
const commentValidation = form => {
	form.classList.add( 'was-validated' );
	if ( false === form.checkValidity() || form.querySelector( '.is-invalid' ) ) {
		return false;
	} else {
		return true;
	}
}


// submit form
const submitComment = form => {
	form.querySelector( '.js_comment_submit' ).classList.add( 'loading' );
	const data = new FormData( form );

	// add files if comment image enabled
	const fileNode = document.querySelector( '.js_field_file_upload' );
	if ( fileNode ) {
		for ( const file of fileNode.files ) {
			data.append( 'files[]', file, file.name )
		}
	}

	// send data
	fetch( starter_ajax.ajax_url, {
		method: 'post',
		body: data
	})
	.then( response => response.json() )
	.then( data => {
		if ( data.success ) {
			new bootstrap.Collapse( document.querySelector( '.js_comment_form' ), {hide: true} )
			new bootstrap.Collapse( document.querySelector( '.js_comment_form_sent' ), {show: true} )
		} else {
			const errors = data.data;

			// custom errors
			if ( 'object' == typeof errors ) {
				errors.forEach( error => {
					switch ( error.code ) {
						case error.code: form.querySelector( '[data-' + error.code + ']' ).classList.add( 'is-invalid', error.code ); break;
					}
				})
			}

			// default wp/woo errors
			if ( 'string' == typeof errors ) {
				document.querySelector( '.js_custom_alert_txt' ).innerHTML = errors;
				document.querySelector( '.js_comment_form' ).insertAdjacentHTML( 'beforeend', document.querySelector( '.js_custom_alert' ).innerHTML );
			}

			// remove class 'loading' and reset recaptcha
			form.querySelector( '.js_comment_submit' ).classList.remove( 'loading' );
			if ( form.querySelector( '.g-recaptcha' ) ) {
				let widgetId = form.querySelector( '.g-recaptcha' ).getAttribute( 'data-widget-id' );
				grecaptcha.reset( widgetId );
			}
		}
	});
}
const commentForm = document.querySelector( '.js_comment_form' );
if ( commentForm ) {
	commentForm.addEventListener( 'submit', e => {
		e.preventDefault();
		const form = e.currentTarget;
		if ( !commentValidation( form ) ) {
			return;
		}
		if ( document.querySelector( '.js_low_rating_modal' ) ) {
			commentMinimumRating( form );
		} else {
			submitComment( form );
		}
	})
}


// load more comments
const loadMoreComments = () => {
	const btn = document.querySelector( '.js_comment_show_more' );
	if ( !btn ) return;

	btn.addEventListener( 'click', e => {
		e.preventDefault();
		btn.classList.add( 'loading' );

		// collect data
		const post_id = btn.getAttribute( 'data-post_id' );
		const offset = document.querySelectorAll( '.js_comment_item' ).length;
		const data = new FormData();
		data.append( 'action', 'comment_load' );
		data.append( 'post_id', post_id );
		data.append( 'offset', offset );

		// send data
		fetch( starter_ajax.ajax_url, {
			method: 'post',
			body: data
		})
		.then( response => response.text() )
		.then( body => {
			const commentsList = document.querySelector( '.js_comment_list' );
			commentsList.insertAdjacentHTML( 'beforeend', body );
			const totalComments = commentsList.getAttribute( 'data-comment-total' );
			const showComments = commentsList.querySelectorAll( '.js_comment_item' ).length;

			if ( showComments == totalComments ) {
				btn.remove();
			} else {
				btn.classList.remove( 'loading' );
			}
		})
	} )
}
loadMoreComments();