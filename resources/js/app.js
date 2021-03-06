/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import User from './helpers/User';
import Fuse from 'fuse.js';

window.User = User;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-home', require('./AppHome.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.prototype.$search = function (term, list, options) {
    return new Promise(function (resolve, reject) {
      var run = new Fuse(list, options)
      var results = run.search(term)
      resolve(results)
    })
  }
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './routes/routes.js';

const app = new Vue({
    el: '#app',
    router
});
