/**
 * Render recaptcha on related active form
 */
function recaptchaOnloadCallback() {
	let activeRecaptcha = document.querySelector( '.js_active_recaptcha' );
	grecaptcha.render( activeRecaptcha, {
		'sitekey' : activeRecaptcha.dataset.recaptchapublickey
	});
	activeRecaptcha.classList.add( 'recaptcha_inited' );
	activeRecaptcha.classList.remove( 'js_active_recaptcha' );
}

/**
 * Load recaptcha by click on certain form
 */
function loadRecaptchaOnClick() {
	// return if no recaptcha
	if ( ! document.querySelector( '.g-recaptcha' ) ) {
		return false;
	}
	// add class to each form with recaptcha
	Array.from( document.querySelectorAll( '.js_recaptcha_input' ) ).forEach( function(e) {
		e.form.classList.add( 'js_form_with_recaptcha' );
	});
	// proccess recaptcha by click
	var form = document.getElementsByClassName( 'js_form_with_recaptcha' );
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
 * Recaptcha validation
 */
document.querySelectorAll( '.js_form_with_recaptcha' ).forEach( form => form.addEventListener( 'submit', function(e) {
	var res = form.querySelector( '.g-recaptcha-response' ).value;
	if ( res == '' || res == undefined || res.length == 0 ) {
		form.querySelector( '.g-recaptcha' ).classList.add( 'is-invalid' );
		e.preventDefault();
	}
}, false));

/**
 * Callback recaptcha function
 */
function recaptchaCallback() {
	Array.from( document.querySelectorAll( '.g-recaptcha' ) ).forEach( function(e) {
		e.classList.remove( 'is-invalid' );
	});
}