require('./bootstrap');

window.Vue = require('vue');
import router from './router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faCog,
} from '@fortawesome/free-solid-svg-icons';

library.add(
    faCog,
);

Vue.component('font-awesome-icon', FontAwesomeIcon);

const app = new Vue({
    router,

    el: '#app',

    data: {
        game: '',
        users: [],
        player: {
            name: null,
            score: null,
        },
    },

    template: `
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    `
});
