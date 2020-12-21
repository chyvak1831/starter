/**
 * Render recaptcha on related active form
 */
function recaptchaOnloadCallback() {
	let activeRecaptcha = document.querySelector( '.js_active_recaptcha' );
	recaptchaId = grecaptcha.render( activeRecaptcha, {
		'sitekey' : activeRecaptcha.dataset.recaptchapublickey
	});
	activeRecaptcha.setAttribute( 'data-widget-id', recaptchaId );
	activeRecaptcha.classList.add( 'recaptcha_inited' );
	activeRecaptcha.classList.remove( 'js_active_recaptcha' );
}

/**
 * Load recaptcha by click on certain contact form7
 */
function loadRecaptchaOnClick() {
	var form = document.getElementsByClassName( 'js_form_with_recaptcha' );
	if ( ! document.querySelector( '.js_form_with_recaptcha .g-recaptcha' ) ) {
		return false;
	}
	for( var i =0; i < form.length; i++ ) {
		form[i].addEventListener( 'click', function() {
			let recaptchaEl = this.querySelector( '.g-recaptcha');
			recaptchaEl.classList.add( 'js_active_recaptcha' );
			if ( recaptchaEl.classList.contains( 'recaptcha_inited' ) || ! recaptchaEl ) {
				recaptchaEl.classList.remove( 'js_active_recaptcha' );
				return;
			} else {
				let script = document.createElement( 'script' );
				let scriptSrc = 'https://www.google.com/recaptcha/api.js?onload=recaptchaOnloadCallback&render=explicit';
				script.setAttribute( 'src', scriptSrc );
				document.body.appendChild( script );
			}
		}, false );
	}
}
loadRecaptchaOnClick();

/**
 * Callback recaptcha function
 */
function recaptchaCallback() {
	document.querySelector( '[data-widget-id="' + recaptchaId + '"]' ).classList.remove( 'is-invalid' );
}