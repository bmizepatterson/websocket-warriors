require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import router from './router';

const app = new Vue({
    router,
    
    el: '#app',

    template: `
        <span>Status: {{ status }}</span>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    `,

    data: {
        socket: null,
        status: 'Disconnected',
        users: [],
    },

    created() {
        const self = this;

        self.socket = new WebSocket('ws://localhost:8000/app')

        self.socket.onerror = (error) => {
            self.$refs.status = 'Error';
            console.error('Websocket error: ' + error);
        }

        self.socket.onopen = () => self.$refs.status = 'Connected';

        self.socket.onclose = () => self.$refs.status = 'Disconnected';
    },

    methods: {
    }
});