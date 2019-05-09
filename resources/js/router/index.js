import Vue from 'vue';
import Router from 'vue-router';
import AppMain from '../views/AppMain';
import AppWelcome from '../views/AppWelcome';

Vue.use(Router);

export default new Router({
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'welcome',
            component: AppWelcome,
        },
        {
            path: '/play/:gameCode',
            name: 'app',
            component: AppMain,
        },
        {
            path: '*',
            component: {
                template: '<div>Page Not Found</div>',
            },
        }

    ]
});
