// format bytes
const formatBytes = ( bytes, decimals = 2 ) =>  {
    if ( 0 === bytes ) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor( Math.log( bytes ) / Math.log( k ) );

    return parseFloat( ( bytes / Math.pow( k, i ) ).toFixed( dm ) ) + ' ' + sizes[i];
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
		this.wrapPreviewList.classList.remove( 'is-invalid', 'not_empty', 'filelength', 'filesize', 'filetype' );

		// check if filelist empty
		if ( this.previewList.firstChild ) {
			this.wrapPreviewList.classList.add( 'not_empty' )
		}

		// check if filelist length valid
		const lengthFiles = this.previewList.querySelectorAll( 'li' ).length;
		if ( lengthFiles > this.maximumFiles ) {
			this.wrapPreviewList.classList.add( 'is-invalid', 'filelength' );
		}

		// check if filesize valid
		for ( let i = 1; i < lengthFiles+1; i++ ) {
			let currentItem = this.previewList.querySelector( 'li:nth-child(' + i + ')' );
			let size = parseFloat( currentItem.querySelector( '.js_file_size' ).getAttribute( 'data-size' ) );
			if ( size > this.maximumWeight ) {
				this.wrapPreviewList.classList.add( 'is-invalid', 'filesize' );
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