import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

/*import 'bootstrap/js/dist/alert';
// import 'bootstrap/js/dist/button';
// import 'bootstrap/js/dist/carousel';
import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/offcanvas';
// import 'bootstrap/js/dist/popover';
// import 'bootstrap/js/dist/scrollspy';
// import 'bootstrap/js/dist/tab';
// import 'bootstrap/js/dist/toast';
// import 'bootstrap/js/dist/tooltip';*/

import Swiper from 'swiper/bundle';
/*import Swiper, { Navigation, Thumbs } from 'swiper';
Swiper.use([Navigation, Thumbs]);*/
window.Swiper = Swiper;

import './../modules/wp/common.js';
import './../modules/wp/menus.js';
import './../modules/wp/recaptcha.js';
import './../modules/wp/comment/comment.js';

import './../modules/woo/archive.js';
import './../modules/woo/carousel.js';
import './../modules/woo/review.js';
import './../modules/woo/single_product.js';
import './../modules/woo/woo.js';