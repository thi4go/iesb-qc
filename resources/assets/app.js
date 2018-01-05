/*
Put the routes addresses into here, an import the generics-front library
 */

// window.api = "http://localhost:3000/api/";
window.api = "https://iesbapi.examedaoab.com/api/";
window.local = "https://iesb.examedaoab.com/api/";
window.siteUrl = "http://localhost:8000/";
require('../assets/firebase/schedule');
require('../assets/firebase/quiz');
require('../assets/firebase/user-questions');
require('../assets/Calculator');
require('../assets/DateHelper');
require('../generics-front');

Vue.component('promo-subscription',
    require('./components/PromoSubs.vue')
);
const payment = new Vue({
    el: '#payment'
});
