/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import CompaignList from "./components/CompaignList";

require('./bootstrap');

window.Vue = require('vue').default;

import Buefy from 'buefy';
import 'buefy/dist/buefy.css';
import axios from 'axios';
import AddCompaign from "./components/AddCompaign";
import UpdateCompaign from "./components/UpdateCompaign";
import OpenUploads from "./components/OpenUploads";

window.axios = axios;
const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('compaign-list', CompaignList);
Vue.component('add-compaign', AddCompaign);
Vue.component('update-compaign', UpdateCompaign);
Vue.component('open-uploads', OpenUploads);

Vue.use(Buefy);

const app = new Vue({
    el: '#app',
});
