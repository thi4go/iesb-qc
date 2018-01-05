
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 * Vue global packages (NOT FROM EDUQC)
 */
import VueMask from 'v-mask'
Vue.use(VueMask);
Vue.use(require('vue-resource'));
//------------------------------------------------------------------------//

Vue.http.options.emulateJSON = true;

//-----------------------------------------------------------------------//
// Quiz related components
//-----------------------------------------------------------------------//
Vue.component('quiz',
    require('./components/quiz/Quiz.vue')
);

Vue.component('feedback',
    require('./components/quiz/Feedback.vue')
);

Vue.component('quiz-landing',
    require('./components/quiz/QuizLanding.vue')
);

Vue.component('quiz-table',
    require('./components/quiz/QuizTable.vue')
);


//-----------------------------------------------------------------------//
// Question related components
//-----------------------------------------------------------------------//
Vue.component('question-paginate',
    require('./components/question/QuestionPaginate.vue')
);

Vue.component('question-shower',
    require('./components/question/QuestionShower.vue')
);

Vue.component('question-resolution',
    require('./components/question/QuestionResolution.vue')
);

Vue.component('question-counter-pagination',
    require('./components/question/QuestionCounterPagination.vue')
);

Vue.component('question-feedback',
    require('./components/question/QuestionFeedback.vue')
);

Vue.component('question-feedback-table',
    require('./components/question/QuestionFeedbackTable.vue')
);


//-----------------------------------------------------------------------//
// Discursive related components
//-----------------------------------------------------------------------//
Vue.component('discursive',
    require('./components/discursive/Discursive.vue')
);

Vue.component('discursive-filter',
    require('./components/discursive/DiscursiveFilter.vue')
);

Vue.component('discursive-question-shower',
    require('./components/discursive/DiscursiveQuestionShower.vue')
);

Vue.component('discursive-feedback',
    require('./components/discursive/DiscursiveFeedback.vue')
);

Vue.component('discursive-resolved-questions',
    require('./components/discursive/DiscursiveResolvedQuestions.vue')
);


//-----------------------------------------------------------------------//
// Admin related components
//-----------------------------------------------------------------------//
Vue.component('question-topic-changer',
    require('./components/admin/QuestionTopicChanger.vue')
);


//-----------------------------------------------------------------------//
// Dashboard related components
//-----------------------------------------------------------------------//
Vue.component('dashboard-panel',
    require('./components/dashboard/DashboardPanel.vue')
);

Vue.component('quiz-panel',
    require('./components/dashboard/QuizPanel.vue')
);

Vue.component('full-quiz-graph',
    require('./components/dashboard/FullQuizzGraph.vue')
);


Vue.component('subject-panel',
    require('./components/dashboard/SubjectPanel.vue')
);


Vue.component('full-dashboard',
    require('./components/dashboard/FullDashboard.vue')
);

Vue.component('contact-form',
    require('./components/dashboard/ContactForm.vue')
);


//-----------------------------------------------------------------------//
// Filter related components
//-----------------------------------------------------------------------//
Vue.component('question-filter',
    require('./components/filter/QuestionFilter.vue')
);

Vue.component('question-filter-complete',
    require('./components/filter/QuestionFilterComplete.vue')
);

Vue.component('question-filter-counter',
    require('./components/filter/QuestionFilterCounter.vue')
);


//-----------------------------------------------------------------------//
// General components
//-----------------------------------------------------------------------//
Vue.component('app-download',
    require('./components/general/AppDownload.vue')
);

Vue.component('graph',
    require('./components/general/Graph.vue')
);

Vue.component('quiz-graph',
    require('./components/quiz/QuizGraph.vue')
);

Vue.component('timer',
    require('./components/general/Timer.vue')
);

Vue.component('count-down',
    require('./components/general/CountDown.vue')
);

Vue.component('report-error',
    require('./components/general/ReportError.vue')
);

Vue.component('page-loader',
    require('./components/general/PageLoader.vue')
);

Vue.component('custom-modal',
    require('./components/general/CustomModal.vue')
);

//-----------------------------------------------------------------------//
// Marketing components
//-----------------------------------------------------------------------//
Vue.component('eu-quero-model',
    require('./components/marketing/EuQuero.vue')
);

Vue.component('depoiment-panel',
    require('./components/marketing/Depositions.vue')
);

Vue.component('contact-info',
    require('./components/marketing/Contact.vue')
);

Vue.component('result',
    require('./components/marketing/Result.vue')
);

//-----------------------------------------------------------------------//
// Theory components
//-----------------------------------------------------------------------//

Vue.component('course-wrapper',
    require('./components/theory/courses/CourseWrapper.vue')
);

Vue.component('course-card',
    require('./components/theory/courses/CourseCard.vue')
);

Vue.component('course-show',
    require('./components/theory/courses/CourseShow.vue')
);

Vue.component('lesson-wrapper',
    require('./components/theory/lessons/LessonWrapper.vue')
);

Vue.component('lesson-article',
    require('./components/theory/lessons/LessonArticle.vue')
);

Vue.component('lesson-video',
    require('./components/theory/lessons/LessonVideo.vue')
);


//-----------------------------------------------------------------------//
// Wizard components
//-----------------------------------------------------------------------//

Vue.component('tutorial',
    require('./components/wizard/Tutorial.vue')
);
//-----------------------------------------------------------------------//
// Profile Components
//-----------------------------------------------------------------------//

Vue.component('profile-wrapper',
    require('./components/profile/ProfileWrapper.vue')
);
Vue.component('side-profile',
    require('./components/profile/SideProfile.vue')
);

Vue.component('profile-picture',
    require('./components/profile/ProfilePicture.vue')
);

Vue.component('profile-info',
    require('./components/profile/ProfileInfo.vue')
);

Vue.component('update-password',
    require('./components/profile/UpdatePassword.vue')
);

Vue.component('payment-records',
    require('./components/profile/PaymentRecords.vue')
);

//-----------------------------------------------------------------------//
// Scheduled components
//-----------------------------------------------------------------------//
Vue.component('cycle-wrapper',
    require('./components/scheduler/CycleWrapper.vue')
);

Vue.component('graph-schedule',
    require('./components/scheduler/GraphSchedule.vue')
);


Vue.component('landing-control',
    require('./components/scheduler/LandingControl.vue')
);

Vue.component('availability',
    require('./components/scheduler/Availability.vue')
);

Vue.component('objective',
    require('./components/scheduler/Objective.vue')
);

Vue.component('select-subject',
    require('./components/scheduler/SelectSubject.vue')
);

Vue.component('completed-percentage',
    require('./components/scheduler/CompletedPercentage.vue')
);

Vue.component('side-wizard',
    require('./components/scheduler/SideWizard.vue')
);

Vue.component('cycle',
    require('./components/scheduler/Cycle.vue')
);

Vue.component('pomodoro-table',
    require('./components/scheduler/PomodoroTable.vue')
);

Vue.component('pomodoro',
    require('./components/scheduler/Pomodoro.vue')
);

Vue.component('pomodoro-line',
    require('./components/scheduler/PomodoroLine.vue')
);

//-----------------------------------------------------------------------//
// Navigation components
//-----------------------------------------------------------------------//
Vue.component('nav-bar-vue',
    require('./components/navigation/NavBar.vue')
);


//-----------------------------------------------------------------------//
// Area components
//-----------------------------------------------------------------------//
Vue.component('course-area',
    require('./components/area/Area.vue')
);

//-----------------------------------------------------------------------//
// Authentication components
//-----------------------------------------------------------------------//
Vue.component('forget-page',
    require('./components/auth/ForgotPassword.vue')
);

Vue.component('change-password',
    require('./components/auth/ChangePassword.vue')
);

Vue.component('register-page',
    require('./components/auth/Register.vue')
);

Vue.component('register-chimp',
    require('./components/auth/RegisterChimp.vue')
);

//-----------------------------------------------------------------------//
// Payment components
//-----------------------------------------------------------------------//
// Vue.component('promo-subscription',
//     require('./components/PromoSubs.vue')
// );

String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = '0'+hours;}
    if (minutes < 10) {minutes = '0'+minutes;}
    if (seconds < 10) {seconds = '0'+seconds;}
    return hours+':'+minutes+':'+seconds;
}

String.prototype.toHHMM = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);

    if (hours   < 10) {hours   = '0'+hours;}
    if (minutes < 10) {minutes = '0'+minutes;}
    return hours+':'+minutes;
}

String.prototype.toHHMMtext = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);

    if (hours   < 10) {hours   = '0'+hours;}
    if (minutes < 10) {minutes = '0'+minutes;}
    return hours+'h'+minutes;
}

String.prototype.toHH = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = '0'+hours;}
    return hours;
}


(function(d, s, id) {
    window.Wishpond = window.Wishpond || {};
    Wishpond.merchantId = '1330581';
    Wishpond.writeKey = 'c01c00209aae';
    var js, wpjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//cdn.wishpond.net/connect.js";
    wpjs.parentNode.insertBefore(js, wpjs);
}(document, 'script', 'wishpond-connect'));


const app = new Vue({
    el: '#app'
});
