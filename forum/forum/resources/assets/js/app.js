
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');
//window.Vue = require('vue-resource');
//import VueResource from 'vue-resource';
//Vue.use(VueResource);

import Vue from 'vue';
import VueResource from 'vue-resource';
Vue.use(VueResource);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('question-follow-button', require('./components/QuestionFollowButton.vue'));
Vue.component('user-follow-button', require('./components/UserFollowButton.vue'));
Vue.component('user-vote-button', require('./components/UserVoteButton'));
Vue.component('send_message', require('./components/SendMessage'));
Vue.component('comments', require('./components/Comments'));
Vue.component('manager', require('./components/SetManager'));
Vue.component('editor', require('./components/SetEditor'));

const app = new Vue({
    el: '#app'
});
