// Load recaptcha by click on current form
const loadRecaptchaOnClick = () => {
	const recaptcha = document.querySelectorAll( '.g-recaptcha' );

	recaptcha.forEach( element => {
		const form = element.closest( 'form' );

		// proccess click for form with recaptcha
		form.addEventListener( 'click', () => {
			if ( element.classList.contains( 'recaptcha_inited' ) ) return;

			element.classList.add( 'js_active_recaptcha' );
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
	const recaptcha = document.querySelector( '.js_active_recaptcha' );
	const widgetId = grecaptcha.render( recaptcha, {
		'sitekey' : recaptcha.dataset.recaptchapublickey
	});
	recaptcha.classList.add( 'recaptcha_inited' );
	recaptcha.classList.remove( 'js_active_recaptcha' );
	recaptcha.setAttribute( 'data-widget-id', widgetId );
}


// Callback recaptcha
function recaptchaCallback() {
	const recaptcha = document.querySelectorAll( '.g-recaptcha' );
	[...recaptcha].map( element => element.classList.remove( 'is-invalid' ) );
}