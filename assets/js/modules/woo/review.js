window.addEventListener( 'load', () => {


// rating
class Rating {
	constructor( element ) {
		this.rating = element;
		this.parentRating = this.rating.closest( '.js_ratings_list' );
		this.widthElemRating = this.rating.closest( '.js_rating' ).getAttribute( 'data-elem_width' );
		this.countFilledStar = 0;
	}

	calcFilledStar( e ) {
		const coordMouseX = e.pageX - this.rating.offsetLeft;
		this.countFilledStar = Math.ceil( coordMouseX / this.widthElemRating );
	}

	calcAverageRating() {
		let averageRating = 0;
		const countRatings = this.parentRating.querySelectorAll( '.js_rating' ).length;
		this.parentRating.querySelectorAll( '.js_rating' ).forEach( element => {
			const valueRating = element.closest( '.js_rating' ).querySelector( '.js_rating_input' ).value;
			averageRating += +valueRating;
		});
		averageRating = averageRating / countRatings;
		this.parentRating.querySelector( '.js_total_ratings' ).innerHTML = averageRating.toFixed(2);
	}

	mouseMove( e ) {
		this.calcFilledStar( e );
		const finalRating = this.countFilledStar * this.widthElemRating;
		this.rating.querySelector( '.filled_star' ).style.width = finalRating + 'px';
	}

	mouseLeave( e ) {
		const valueRating = this.rating.closest( '.js_rating' ).querySelector( '.js_rating_input' ).value;
		const finalRating = Math.ceil( this.widthElemRating * valueRating );
		this.rating.querySelector( '.filled_star' ).style.width = finalRating + 'px';
	}

	click( e ) {
		this.calcFilledStar( e );
		this.rating.closest( '.js_rating' ).querySelector( '.js_rating_input' ).value = this.countFilledStar;
		this.rating.closest( '.js_rating' ).querySelector( '.js_rating_input' ).classList.remove( 'is-invalid' );
		this.calcAverageRating();
	}

	init() {
		const value = this.rating.closest( '.js_rating' ).querySelector( '.js_rating_input' ).value;
		this.rating.querySelector( '.filled_star' ).style.width = value * this.widthElemRating + 'px';
		this.calcAverageRating();
		this.rating.addEventListener( 'mousemove', this.mouseMove.bind( this ) );
		this.rating.addEventListener( 'mouseleave', this.mouseLeave.bind( this ) );
		this.rating.addEventListener( 'click', this.click.bind( this ) );
	}
}
const ratingElement = document.querySelectorAll( '.js_rating .wrap_rating_list' );
ratingElement.forEach( element => {
	let rating = new Rating( element );
	rating.init();
})


// comment low-rating modal
window.starterCommentMinimumRating = form => {
	const minimumRating = document.querySelector( '[data-minimum_rating]' ).getAttribute( 'data-minimum_rating' );
	const rating = +form.querySelector( '.js_total_ratings' ).textContent;

	if ( rating >= minimumRating || 0 == rating ) {
		starterSubmitComment( form );
	} else {
		const lowRatingModal = new bootstrap.Modal( document.querySelector( '.js_low_rating_modal' ) );
		lowRatingModal.show();
		document.querySelector( '.js_comment_submit_anyway' ).addEventListener( 'click', e => {
			e.preventDefault();
			starterSubmitComment( form );
			lowRatingModal.hide();
		});
	}
}


});/*end window load event*/