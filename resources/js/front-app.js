/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web
 * applications using Vue and Laravel.
 */
require('./bootstrap');

import {BootstrapVue, BSidebar} from 'bootstrap-vue'
import router from './front-router'

window.Vue = require('vue');

Vue.use(BootstrapVue);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Front-end widgets imports...
Vue.component('insight-ai-chat-gpt-widget', require('./components/Widgets/ChatApp.vue').default);


let element = document.getElementById('app');

if (element !== null) {
    window.frontApp = new Vue({
        el: '#app',
        router,
        data: {
            pluginBASEURL: pluginBASEURL
        },
    })
}
