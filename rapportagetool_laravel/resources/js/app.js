/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('axios');
window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue' //Importing
import vueDebounce from 'vue-debounce' //Importing
Vue.use(BootstrapVue); // Telling Vue to use this in whole application
Vue.use(vueDebounce); // Telling Vue to use this in whole application


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('obj-index', require('./components/obj/ObjIndex.vue').default);
Vue.component('obj-index-nav', require('./components/obj/ObjIndexNav.vue').default);
Vue.component('casenotes', require('./components/casenotes/Casenotes.vue').default);

//Generics
Vue.component('generic-small-link', require('./components/generic/links/GenericSmallLink.vue').default);
Vue.component('generic-small-date-with-time', require('./components/generic/date_time/GenericSmallDateWithTime.vue').default);
Vue.component('generic-dropdown', require('./components/generic/dropdowns/GenericDropdown.vue').default);
Vue.component('generic-search-list', require('./components/generic/lists/GenericSearchList.vue').default);
Vue.component('generic-objects-list', require('./components/generic/lists/GenericObjectsList.vue').default);
Vue.component('generic-dynamic-search-input', require('./components/generic/inputs/GenericDynamicSearchInput.vue').default);

//Modals
Vue.component('objects-selector', require('./components/modals/ObjectsSelector.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//passport
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


const app = new Vue({
    el: '#app',
});


import 'jquery-ui/ui/widgets/datepicker.js';
import 'jquery-ui/ui/widgets/sortable.js';
import 'jquery-ui/ui/widgets/draggable.js';
import 'jquery-ui/ui/disable-selection.js';

require('./custom.js');


