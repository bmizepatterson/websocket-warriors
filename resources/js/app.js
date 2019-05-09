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
        channel: '',
        joined: false,
        users: [],
        player: {
            name: '',
            score: 0,
        }
    },

    template: `
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    `,

    methods: {
        join(game) {
            this.game = {
                id: game.id,
                code: game.code,
                created_at: game.created_at,
                updated_at: game.updated_at,
            };
            console.log('Registering player:', this.player);
            return axios.put('/api/play/' + game.id, this.player).then(response => {
                console.log('Registered ' + this.player.name + ' in game ' + game.code);
                console.log('Users in game ' + game.code + ':', response.data);
                this.users = response.data;
                this.player = response.data.filter(u => u.name === this.player.name)[0];
                this.channel = 'game.' + game.id;    
                this.joined = true;            
            })
        }
    }
});
