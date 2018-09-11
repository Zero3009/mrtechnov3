
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import jquery from 'jquery';
import popper from 'popper.js';
import Vue from 'vue';
import vSelect from 'vue-select';
import Datepicker from 'vuejs-datepicker';
import axios from 'axios';
import vuetable from 'vuetable-2';
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
import moment from 'moment';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('moment', moment);
Vue.component('v-select', vSelect);
Vue.component('axios', axios);
Vue.component('vuetable', vuetable);
Vue.component('vuetable-pagination', VuetablePagination);
Vue.component('vuejs-datepicker', Datepicker);
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('stock', require('./components/stock.vue'));
Vue.component('productos', require('./components/productos.vue'));
Vue.component('productosnuevo', require('./components/productosnuevo.vue'));
Vue.component('proveedores', require('./components/proveedores'));
Vue.component('vuetablestock', require('./components/vuetablestock'));

const app = new Vue({
    el: '#app'
});
