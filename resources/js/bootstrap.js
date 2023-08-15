window._ = require('lodash')
window._.noConflict();


/**
 * We'll load jQuery and the jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */


try {


    //window.Popper = require('popper.js').default;
    //window.$ = window.jQuery = require('jquery');

    window.moment = require('moment');
    window.Snackbar = require('node-snackbar');
    window.Tipped = require('@staaky/tipped');
    require('jquery-confirm');

} catch (e) {}


/**`
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['Content-Type'] = 'application/json;charset=UTF-8'
window.axios.defaults.headers.common['Accept'] = 'application/json'

if (window.wpApiSettings !== undefined && window.wpApiSettings.nonce !== undefined) {
    window.axios.defaults.headers.common['X-WP-Nonce'] = window.wpApiSettings.nonce
}


let pluginBASEURL = window.pluginBASEURL = "";
let pluginPREFIX = window.pluginPREFIX = "";
let pluginMediaPath = window.pluginMediaPath = "";
if (document.getElementsByTagName('meta')["pluginBASEURL"] !== undefined) {
    pluginBASEURL = window.pluginBASEURL = document.getElementsByTagName('meta')["pluginBASEURL"].content;
}

if (document.getElementsByTagName('meta')["pluginPREFIX"] !== undefined) {
    pluginPREFIX = window.pluginPREFIX = document.getElementsByTagName('meta')["pluginPREFIX"].content;
}
if (document.getElementsByTagName('meta')["pluginMediaPath"] !== undefined) {
    pluginMediaPath = window.pluginMediaPath = document.getElementsByTagName('meta')["pluginMediaPath"].content;
}
/*window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
window.csrf_token = token;

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}*/
