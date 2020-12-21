jQuery( document ).ready( function( $ ) {


// validate simple fields (name, email, comment, privacy) and recaptcha function
function commentValidation( form ) {
	form.addClass( 'was-validated' );
	// recaptcha: check if enabled AND return validation 'false' if recaptcha failed
	var res = form.find( '.g-recaptcha-response' ).length ? form.find( '.g-recaptcha-response' ).val() : true;
	if ( res == '' || res == undefined || res.length == 0 ) {
		form.find( '.g-recaptcha' ).addClass( 'is-invalid' );
		return false;
	// END recaptcha: check if enabled AND return validation 'false' if recaptcha failed
	} else if ( form[0].checkValidity() === false || form.find( '.is-invalid' ).length ) {
		return false;
	} else {
		return true;
	}
}


// submit form function
function submitComment( form ) {
	if ( form.find( '.js_list_file_upload .template-upload' ).length ) {// send form and files if present
		$( '.js_field_file_upload' ).fileupload( 'send', { files: filelistform } );
	} else {// send form when no files
		$.ajax({
			url: starter_ajax.ajax_url,
			type: 'POST',
			data: new FormData( form[0] ),
			cache: false,
			contentType: false,
			processData: false,
			xhr: function() {
				return $.ajaxSettings.xhr();
			},
			success: function ( data ) {
				processingResponse( form, data );
			},
			error: function ( data ) {
				location.reload();
			}
		});
	}
}
// parse server response function
function processingResponse( form, response ) {
	if ( response.success ) {
		$( '.js_comment_form, .js_comment_form_sent' ).slideToggle();
	} else {
		if ( form.find( '.g-recaptcha' ).length ) {
			grecaptcha.reset( recaptchaId );
		}
		var errors = response.data;
		// custom errors
		for ( const error in errors ) {
			switch ( error ) {
				case 'limit_files':
					form.find( '.js_wrap_upload_files' ).addClass( 'is-invalid' );
					form.find( '.js_filelength_invalid_feedback' ).addClass( 'd-block' );
					break;
				case 'limit_file_size':
					form.find( '.js_wrap_upload_files' ).addClass( 'is-invalid' );
					form.find( '.js_filesize_invalid_feedback' ).addClass( 'd-block' );
					break;
				case 'not_allowed_type':
					form.find( '.js_wrap_upload_files' ).addClass( 'is-invalid' );
					form.find( '.js_type_invalid_feedback' ).addClass( 'd-block' );
					break;
				case 'g-recaptcha-response': form.find( '.g-recaptcha' ).addClass( 'is-invalid' ); break;
				case 'privacy_policy': form.find( '[name="privacy_policy"]' ).addClass( 'is-invalid' ); break;
				case 'price_rating': form.find( '[name="price_rating"]' ).addClass( 'is-invalid' ); break;
				case 'shipping_rating': form.find( '[name="shipping_rating"]' ).addClass( 'is-invalid' ); break;
				case 'quality_rating': form.find( '[name="quality_rating"]' ).addClass( 'is-invalid' ); break;
				case 'rating': form.find( '[name="rating"]' ).addClass( 'is-invalid' ); break;
			}
		}
		// default wp/woo errors
		if ( 'string' == typeof errors ) {
			$( '#write_comment' ).append( $( '.js_custom_alert' ).html() ).find( '.js_custom_alert_txt' ).html( errors );
		}
		form.find( '.js_comment_submit' ).removeClass( 'loading' );
	}
}
// submit form event
$( '.js_comment_form' ).submit( function( e ) {
	e.preventDefault();
	e.stopPropagation();
	var form = $( this );
	if ( !commentValidation( form ) ) {
		return;
	}
	form.find( '.js_comment_submit' ).addClass( 'loading' );
	if ( $( '.js_low_rating_modal' ).length ) {
		commentMinimumRating( form );
	} else {
		submitComment( form );
	}
});


// reset privacy validation when privacy true
$( '.js_comment_privacy' ).change( function() {
	$( this ).removeClass( 'is-invalid' );
})




// FILEUPLOADER
// validate file function
function validateFile ( fileInput ) {
	var parentSelector = $( fileInput ).closest( '.js_wrap_upload_files' );
	var fileList = parentSelector.find( '.js_list_file_upload' );
	var lengthFiles = fileList.find( 'li' ).length;
	var maximumFiles = +parentSelector.find( '.js_field_file_upload' ).data( 'length' );
	var maximumWeight = +parentSelector.find( '.js_field_file_upload' ).data( 'weight' )*1000000;
	parentSelector.removeClass( 'is-invalid' );
	parentSelector.find( '.js_field_file_upload' ).removeClass( 'not_empty' );
	parentSelector.find( '.invalid-feedback' ).removeClass( 'd-block' );
	if ( fileList.children().length )
		parentSelector.find( '.js_field_file_upload' ).addClass( 'not_empty' );
	if ( lengthFiles > maximumFiles ) {
		parentSelector.addClass( 'is-invalid' );
		parentSelector.find( '.js_filelength_invalid_feedback' ).addClass( 'd-block' );
	}
	for ( var i = 0; i < lengthFiles; i++ ) {
		var size = fileList.find( 'li' ).eq( i ).find( '.js_file_size' ).data( 'size' );
		if ( maximumWeight < size ) {
			parentSelector.addClass( 'is-invalid' );
			fileList.find( 'li' ).eq( i ).addClass( 'error_filesize' );
			parentSelector.find( '.js_filesize_invalid_feedback' ).addClass( 'd-block' );
		}
	}
}
// load script function
function loadScript ( arr, index, callback ) {
	if ( index != arr.length ) {
		$.getScript( arr[ index ] ).done( function() {
			loadScript( arr, index + 1, callback );
		} );
	} else {
		callback();
	}
}
// init file upload function
function initFileUpload() {
	$( '.js_field_file_upload' ).each( function() {
		var $this = $( this ),
			form = $this.closest( 'form' ),
			list_file_upload = form.find( '.js_list_file_upload' );
		uploadImageCommentForm( $this, list_file_upload, form );
	});
}
// load fileuploader by click
$( document ).on( 'click', '.js_field_file_upload', function() {
	if ( $( 'body' ).hasClass( 'loaded_fileuploader' ) ) {
		return;
	} else {
		$( 'body' ).addClass( 'loaded_fileuploader' );
		loadScript( blueimp_script, 0, initFileUpload );
	}
});
// form with file upload/send function
var filelistform = new Array();
function uploadImageCommentForm( selector, list_file_upload, form ) {
	selector.fileupload({
		url: starter_ajax.ajax_url,
		dataType: 'json',
		previewMaxWidth: 96,
		previewMaxHeight: 96,
		previewCrop: true,
		filesContainer: list_file_upload,
		uploadTemplateId: null,
		downloadTemplateId: null,
		uploadTemplate: function ( o ) {
			var rows = $();
			$.each( o.files, function ( index, file ) {
				var file_type = file.type.split( '/' );
				if ( 'image' === file_type[0] ) {
					var size_file = o.formatFileSize( file.size );
					var row = $( $( '.js_fileupload_tpl' ).html() );
					row.find( '.js_file_name' ).text( file.name );
					row.find( '.js_file_size' ).text( size_file ).attr( 'data-size', file.size );
					rows = rows.add( row );
				}
			});
			return rows;
		},
		downloadTemplate: function ( o ) {
			var rows = $();
			$.each( o.files, function () {
				var row = $( '<li></li>' );
				rows = rows.add( row );
			});
			return rows;
		}
	}).on( 'fileuploadadded', function ( e, data ) {
		for ( var i = 0; i < data.files.length; i++ ) {
			filelistform.push( data.files[i] );
		}
		validateFile( e.target );
	}).on( 'fileuploadfailed', function ( e, data ) {
		var indexElem = filelistform.indexOf( data.files[0] );
		filelistform.splice( indexElem, 1 );
		validateFile( e.target );
	}).on( 'fileuploaddone', function ( e, data ) {
		processingResponse( form, data.result );
	});
}




// RATING
// rating function
function RatingProduct( selector ) {
	this.rating            = selector;
	this.parent_rating     = this.rating.closest( '.js_ratings_list' );
	this.width_elem_rating = this.rating.closest( '.js_rating' ).data( 'elem-width' );
	this.count_filled_star = 0;

	this.init();
	this.bindEvents();
};
RatingProduct.prototype = {
	init: function() {
		var value = this.rating.closest( '.js_rating' ).find( '.js_rating_input' ).val();
		this.rating.find( '.filled_star' ).css( 'width', value * this.width_elem_rating );
		this.calcAverageRating();
	},

	bindEvents: function() {
		this.rating.bind( 'mousemove', this.mouseMove.bind( this ) );
		this.rating.bind( 'mouseleave', this.mouseLeave.bind( this ) );
		this.rating.bind( 'click', this.click.bind( this ) );
	},

	mouseMove: function( e ) {
		this.calcFilledStar( e );
		var final_rating = this.count_filled_star * this.width_elem_rating;
		this.rating.find( '.filled_star' ).css( 'width', final_rating );
	},

	mouseLeave: function( e ) {
		var value_rating = this.rating.closest( '.js_rating' ).find( '.js_rating_input' ).val();
		var final_rating = Math.ceil( this.width_elem_rating * value_rating );
		this.rating.find( '.filled_star' ).css( 'width', final_rating );
	},

	click: function( e ) {
		this.calcFilledStar( e );
		this.rating.closest( '.js_rating' ).find( '.js_rating_input' ).val( this.count_filled_star ).removeClass( 'is-invalid' );
		this.calcAverageRating();
	},

	calcFilledStar: function( e ) {
		var offset = this.rating.offset();
		var coord_mouse_x = e.pageX - offset.left;
		this.count_filled_star = Math.ceil( coord_mouse_x / this.width_elem_rating );
	},

	calcAverageRating: function() {
		var average_rating = 0;
		var count_ratings = this.parent_rating.find( '.js_rating' ).length;
		this.parent_rating.find( '.js_rating' ).each( function() {
			var value_rating = $( this ).closest( '.js_rating' ).find( '.js_rating_input' ).val();
			average_rating += +value_rating;
		});
		average_rating = average_rating / count_ratings;
		this.parent_rating.find( '.js_total_ratings' ).html( average_rating.toFixed(2) );
	}
}
// init rating
$( '.js_rating .wrap_rating_list' ).each( function() {
	var selector = $( this );
	new RatingProduct( selector );
} );
// comment low-rating modal
function commentMinimumRating( form ) {
	var minimumRating = $( '[data-minimum-rating]' ).data( 'minimum-rating' );
	var rating = +form.find( '.js_total_ratings' ).text();
	if ( rating >= minimumRating || 0 == rating ) {
		submitComment( form );
	} else {
		form.addClass( 'js_submiting_form' );
		$( '.js_low_rating_modal' ).modal( 'show' );
	}
}
$( document ).on( 'click', '.js_comment_submit_anyway', function( e ) {
	e.preventDefault();
	var form = $( '.js_submiting_form' );
	submitComment( form );
	$( '.js_comment_submit_anyway' ).addClass( 'js_lowrate_comment_sent' );
	$( '.js_low_rating_modal' ).modal( 'hide' );
});
$( '.js_low_rating_modal' ).on( 'hidden.bs.modal ', function ( e ) {
	var form = $( '.js_submiting_form' );
	if ( ! $( '.js_lowrate_comment_sent' ).length ) {
		form.find( '.js_comment_submit' ).removeClass( 'loading' );
	}
	$( '.js_lowrate_comment_sent' ).removeClass( 'js_lowrate_comment_sent' );
	form.removeClass( '.js_submiting_form' );
});




// load more comments
$( document ).on( 'click', '.js_comment_show_more', function( e ) {
	e.preventDefault();
	var btn = $( this );
	btn.addClass( 'loading' );
	var product_id = btn.data( 'product_id' );
	var offset = $( '.js_comment_item' ).length;
	var data = {
		action: 'comment_load',
		product_id: product_id,
		offset: offset
	};
	$.post( starter_ajax['ajax_url'], data, function( response ) {
		$( '.js_comment_list' ).append( response );
		var commentsList = $( '.js_comment_list' );
		var totalComments = commentsList.data( 'comment-total' );
		var show_comments = commentsList.find( '.js_comment_item' ).length;
		if ( show_comments == totalComments ) {
			btn.remove();
		} else {
			btn.removeClass( 'loading' );
		}
	});
});


// comment image modal
$( document ).on( 'click', '.js_comment_img_modal_btn', function( e ) {
	e.preventDefault();
	$( '.main_wrap' ).addClass( 'main_loading' );
	var comment_id = $( this ).closest( '.js_comment_item' ).attr( 'data-comment_id' );
	var data = {
		action: 'comment_image',
		comment_id: comment_id,
	};
	$.post( starter_ajax['ajax_url'], data, function( response ) {
		$( '.main_wrap' ).append( response ).removeClass( 'main_loading' );
		$( '.js_comment_img_modal' ).modal( 'show' );
		// call on load img due modal loaded via ajax
		$( '.js_comment_img_modal .js_main_img img' ).on( 'load', function() {
			$( this ).closest( '.js_wrap_img_thumbnails' ).find( '.js_main_img' ).removeClass( 'main_loading' ).toggleClass( 'd-none' );
		});
	});
} );
$( document ).on( 'hidden.bs.modal', '.js_comment_img_modal', function() {
	$( '.js_comment_img_modal' ).remove();
});


})