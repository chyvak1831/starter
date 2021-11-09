// Load recaptcha by click on current form
function loadRecaptchaOnClick() {
	const recaptchaNode = document.querySelectorAll( '.g-recaptcha' );
	if ( 0 == recaptchaNode.length ) return;

	recaptchaNode.forEach( recaptcha => {
		const form = recaptcha.closest( 'form' );

		// proccess click for form with recaptcha
		form.addEventListener( 'click', () => {
			if ( recaptcha.classList.contains( 'recaptcha_inited' ) ) return;
			recaptcha.classList.add( 'js_active_recaptcha' );
			const script = document.createElement( 'script' );
			const scriptSrc = 'https://www.google.com/recaptcha/api.js?onload=recaptchaOnloadCallback&render=explicit';
			script.setAttribute( 'src', scriptSrc );
			document.body.appendChild( script );
		});

		// recaptcha validation
		form.addEventListener( 'submit', e => {
			const res = e.currentTarget.querySelector( '.g-recaptcha-response' ).value;
			if ( res == '' || res == undefined || res.length == 0 ) {
				e.currentTarget.querySelector( '.g-recaptcha' ).classList.add( 'is-invalid' );
				e.preventDefault();
			}
		});
	});
}
loadRecaptchaOnClick();


// Render recaptcha on current form
function recaptchaOnloadCallback() {
	const recaptchaNode = document.querySelector( '.js_active_recaptcha' );
	const widgetId = grecaptcha.render( recaptchaNode, {
		'sitekey' : recaptchaNode.dataset.recaptchapublickey
	});
	recaptchaNode.classList.add( 'recaptcha_inited' );
	recaptchaNode.classList.remove( 'js_active_recaptcha' );
	recaptchaNode.setAttribute( 'data-widget-id', widgetId );
}


// Callback recaptcha
function recaptchaCallback() {
	const recaptchaNode = document.querySelectorAll( '.g-recaptcha' );
	[...recaptchaNode].map( element => element.classList.remove( 'is-invalid' ) );
}