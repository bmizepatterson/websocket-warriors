require('./bootstrap');

window.Vue = require('vue');
import router from './router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faCog, faSignOutAlt,
} from '@fortawesome/free-solid-svg-icons';

library.add(
    faCog, faSignOutAlt,
);

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        el.focus()
    }
});

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
