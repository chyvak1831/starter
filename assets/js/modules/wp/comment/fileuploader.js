window.addEventListener( 'load', () => {


// format bytes
const formatBytes = ( bytes, decimals = 2 ) =>  {
    if ( 0 === bytes ) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor( Math.log( bytes ) / Math.log( k ) );

    return parseFloat( ( bytes / Math.pow( k, i ) ).toFixed( dm ) ) + ' ' + sizes[i];
}

const wrapFileuploader = document.querySelectorAll( '.js_wrap_fileuploader' );
wrapFileuploader.forEach( element => {
	// get preview and input templates
	inputTpl = document.querySelector( '.js_fileuploader_input_tpl' );
	uploadedTpl = document.querySelector( '.js_uploaded_item_tpl' );
	imgTpl = document.querySelector( '.js_uploaded_item_tpl img' );
	fileName = document.querySelector( '.js_uploaded_item_tpl .js_file_name' );
	fileSize = document.querySelector( '.js_uploaded_item_tpl .js_file_size' );

	element.addEventListener( 'change', (e)=> {
		if ( e.target && e.target.matches( '.js_fileuploader_label' ) ) return;

		// get current elements
		const fileuploader = e.target;
		const fileList = fileuploader.files;
		const inputId = fileuploader.getAttribute( 'id' );
		const wrapFileuploader = fileuploader.closest( '.js_wrap_fileuploader' );
		const previewList = wrapFileuploader.querySelector( '.js_uploaded_list' );
		const wrapHiddenInputs = wrapFileuploader.querySelector( '.js_wrap_hidden_fileinputs' );

		// get maximum length & weight
		maximumFiles = wrapFileuploader.getAttribute( 'data-length' );
		maximumWeight = wrapFileuploader.getAttribute( 'data-weight' )*1024*1024;

		// validation
		const validateFile = () => {
			wrapFileuploader.classList.remove( 'is-invalid', 'not_empty', 'filelength', 'filesize', 'filetype' );

			// check if filelist empty
			if ( previewList.querySelector( 'li' ) ) {
				wrapFileuploader.classList.add( 'not_empty' )
			}

			// check if filelist length valid
			let lengthFiles = previewList.querySelectorAll( 'li' ).length;
			if ( lengthFiles > maximumFiles ) {
				wrapFileuploader.classList.add( 'is-invalid', 'filelength' );
			}

			// check if filesize valid
			for ( let i = 1; i < lengthFiles+1; i++ ) {
				let currentItem = previewList.querySelector( 'li:nth-child(' + i + ')' );
				let size = parseFloat( currentItem.querySelector( '.js_file_size' ).getAttribute( 'data-size' ) );
				if ( size > maximumWeight ) {
					wrapFileuploader.classList.add( 'is-invalid', 'filesize' );
					currentItem.classList.add( 'error_filesize' );
				}
			}
		}

		// create previews & hidden input[type='file']
		for ( let i = 0; i < fileList.length; i++ ) {
			// create preview
			imgTpl.src = URL.createObjectURL( fileList[i] );
			fileName.innerHTML = fileList[i].name;
			fileSize.innerHTML = formatBytes( fileList[i].size );
			fileSize.setAttribute( 'data-size', fileList[i].size );
			previewList.insertAdjacentHTML( 'beforeend', uploadedTpl.innerHTML );

			// create input[type='file']
			let hiddenInput = document.createElement( 'input' );
			let dataTransfer = new DataTransfer();
			hiddenInput.setAttribute( 'type', 'file' )
			dataTransfer.items.add( fileList[i] );
			hiddenInput.files = dataTransfer.files;
			wrapHiddenInputs.appendChild( hiddenInput );
		}
		validateFile();
		previewList.addEventListener( 'click', (e)=> {
			validateFile();
		})

		// remove current main input[file] and add new main input[file] - due ios bug
		fileuploader.remove();
		wrapFileuploader.insertAdjacentHTML( 'afterbegin', inputTpl.innerHTML );
		wrapFileuploader.querySelector( '.js_field_file_upload' ).setAttribute( 'id', inputId );
	});

	// remove file
	const previewList = document.querySelectorAll( '.js_uploaded_list' );
	previewList.forEach( element => element.addEventListener( 'click', e => {
		if ( e.target && e.target.matches( '.js_remove_thumb' ) ) {
			e.preventDefault();
			let fileIndex = [...element.children].indexOf( e.target.closest( 'li' ) ) + 1;
			console.log(fileIndex);
			let wrapHiddenInput = e.target.closest( '.js_wrap_fileuploader' ).querySelector( '.js_wrap_hidden_fileinputs' );
			wrapHiddenInput.querySelector( 'input:nth-child(' + fileIndex + ')' ).remove();
			e.target.closest( 'li' ).remove();
		}
	}))
})


});/*end window load event*/