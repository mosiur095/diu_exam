/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue').default;
 import VueRouter from 'vue-router';
 Vue.use(VueRouter);

 import ExampleComponent from './components/ExampleComponent.vue';
 const routes = [
 { path: '/dashboard/:name', component: ExampleComponent }
 ];

 const router = new VueRouter({
 	mode:'history',
 	routes // short for `routes: routes`
});


 const app = new Vue({
 	el: '#app',
 	router
 });
