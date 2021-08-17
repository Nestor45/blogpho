require('./bootstrap');

import '@mdi/font/css/materialdesignicons.css'

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

import {routes} from './routes';
import StoreData from './store';
import MainApp from './components/MainApp.vue';
import {initialize} from './helpers/general';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(Vuetify);


const store = new Vuex.Store(StoreData);
const vuetify = new Vuetify();

const router = new VueRouter({
    routes,
    mode: 'history'
})
initialize(store, router);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    icons: {
        iconfont: 'mdi',
    },
    components: {
        MainApp,
    }
});
