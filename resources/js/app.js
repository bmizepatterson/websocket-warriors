require('./bootstrap');

window.Vue = require('vue');

import router from './router';

const app = new Vue({
    router,

    el: '#app',

    data: {
        users: [],
    },

    template: `
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    `
});
