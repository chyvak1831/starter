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

	// add files if enabled
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
			const collapseNode = document.querySelectorAll( '.js_comment_form, .js_comment_form_sent' );
			collapseNode.forEach( element => { new bootstrap.Collapse( element, {toggle: true} ) } )
		} else {
			const errors = data.data;

			// custom errors
			if ( 'object' == typeof errors ) {
				for ( const error in errors ) {
					switch ( error ) {
						case 'limit_files': form.querySelector( '.js_wrap_upload_files' ).classList.add( 'is-invalid', 'filelength_invalid' ); break;
						case 'limit_file_size': form.querySelector( '.js_wrap_upload_files' ).classList.add( 'is-invalid', 'filesize_invalid' ); break;
						case 'not_allowed_type': form.querySelector( '.js_wrap_upload_files' ).classList.add( 'is-invalid', 'filetype_invalid' ); break;
						case 'privacy_policy': form.querySelector( '[name="privacy_policy"]' ).classList.add( 'is-invalid' ); break;
						case 'g-recaptcha-response': form.querySelector( '.g-recaptcha' ).classList.add( 'is-invalid' ); break;
						case 'price_rating': form.querySelector( '[name="price_rating"]' ).classList.add( 'is-invalid' ); break;
						case 'shipping_rating': form.querySelector( '[name="shipping_rating"]' ).classList.add( 'is-invalid' ); break;
						case 'quality_rating': form.querySelector( '[name="quality_rating"]' ).classList.add( 'is-invalid' ); break;
						case 'rating': form.querySelector( '[name="rating"]' ).classList.add( 'is-invalid' ); break;
					}
				}
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


// format bytes
const formatBytes = (bytes, decimals = 2) =>  {
    if (0 === bytes) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}


// Fileuploader
class FileUploader {
	constructor( element ) {
		// get fileinput elements and datatransfer
		this.fileUploader = element;
		this.wrapPreviewList = this.fileUploader.closest( '.js_wrap_upload_files' );
		this.previewList = this.wrapPreviewList.querySelector( '.js_list_file_upload' );
		this.dataTransfer = new DataTransfer();

		// get maximum length & weight
		this.maximumFiles = this.fileUploader.getAttribute( 'data-length' );
		this.maximumWeight = this.fileUploader.getAttribute( 'data-weight' )*1024*1024;

		// get template elements
		this.imgTpl = document.querySelector( '.js_fileupload_tpl img' );
		this.fileUploadTpl = document.querySelector( '.js_fileupload_tpl' );
		this.fileName = document.querySelector( '.js_fileupload_tpl .js_file_name' );
		this.fileSize = document.querySelector( '.js_fileupload_tpl .js_file_size' );
	}

	validateFile() {
		this.wrapPreviewList.classList.remove( 'is-invalid', 'not_empty', 'filelength_invalid', 'filesize_invalid', 'filetype_invalid' );

		// check if filelist empty
		if ( this.previewList.firstChild ) {
			this.wrapPreviewList.classList.add( 'not_empty' )
		}

		// check if filelist length valid
		const lengthFiles = this.previewList.querySelectorAll( 'li' ).length;
		if ( lengthFiles > this.maximumFiles ) {
			this.wrapPreviewList.classList.add( 'is-invalid', 'filelength_invalid' );
		}

		// check if filesize valid
		for ( let i = 1; i < lengthFiles+1; i++ ) {
			let currentItem = this.previewList.querySelector( 'li:nth-child(' + i + ')' );
			let size = parseFloat( currentItem.querySelector( '.js_file_size' ).getAttribute( 'data-size' ) );
			if ( size > this.maximumWeight ) {
				this.wrapPreviewList.classList.add( 'is-invalid', 'filesize_invalid' );
				currentItem.classList.add( 'error_filesize' );
			}
		}
	}

	createPreview( fileList ) {
		// reset preview list
		this.previewList.innerHTML = '';

		// create preview
		for ( let i = 0; i < fileList.length; i++ ) {
			this.imgTpl.src = URL.createObjectURL( fileList[i] );
			this.fileName.innerHTML = fileList[i].name;
			this.fileSize.innerHTML = formatBytes( fileList[i].size );
			this.fileSize.setAttribute( 'data-size', fileList[i].size );
			this.previewList.insertAdjacentHTML( 'beforeend', this.fileUploadTpl.innerHTML );
		}

		this.validateFile();
	}

	addFile(e) {
		// add files to dataTransfer
		for ( let i = 0; i < this.fileUploader.files.length; i++ ) {
			this.dataTransfer.items.add( this.fileUploader.files[i] );
		}

		this.fileUploader.files = this.dataTransfer.files;

		this.createPreview( this.fileUploader.files );
	}

	removeFile(e) {
		if ( e.target && e.target.matches( '.js_remove_thumb' ) ) {
			e.preventDefault();
			const fileIndex = [...this.previewList.children].indexOf( e.target.closest( 'li' ) );

			// remove item from preview list and from datatransfer
			e.target.closest( 'li' ).remove();
			this.dataTransfer.items.remove( fileIndex );

			// update fileinput with new dataTransfer
			this.fileUploader.files = this.dataTransfer.files;
		}

		this.validateFile();
	}

	init() {
		this.fileUploader.addEventListener( 'change', this.addFile.bind( this ) );
		this.previewList.addEventListener( 'click', this.removeFile.bind( this ) );
	}
}

const fileUploadElement = document.querySelectorAll( '.js_field_file_upload' );
fileUploadElement.forEach( element => {
	let fileUpload = new FileUploader( element );
	fileUpload.init();
})


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


// comment image modal
const loadCommentImgModal = () => {
	const btn = document.querySelectorAll( '.js_comment_img_modal_btn' );
	btn.forEach( element => element.addEventListener( 'click', e => {
		e.preventDefault();
		document.querySelector( '.main_wrap' ).classList.add( 'main_loading' );

		// collect data
		const comment_id = e.currentTarget.closest( '.js_comment_item' ).getAttribute( 'data-comment_id' );
		const data = new FormData();
		data.append( 'action', 'comment_image' );
		data.append( 'comment_id', comment_id );

		// send data
		fetch( starter_ajax.ajax_url, {
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
	}))
}
loadCommentImgModal();