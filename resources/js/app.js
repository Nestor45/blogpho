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

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(Vuetify);


const store = new Vuex.Store(StoreData);
const vuetify = new Vuetify();

const router = new VueRouter({
    routes,
    mode: 'history'
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// router.beforeEach((to, from, next) => {
//     const requireAuth = to.matched.some(record => record.meta.requireAuth)
//     const currentUser = store.state.currentUser

//     if(requireAuth && !!currentUser) {
//         next('/login')
//     } else if(to.path == '/login' && currentUser){
//         next('/')
//     }else {
//         next()
//     }
// })
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
