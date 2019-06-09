
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

// /**
//  * Materialise.css
//  */
// require('materialize-css');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */ 

Vue.component('chord', require('Public/components/Chord.vue'));
Vue.component('external-view', require('Public/components/ExternalView.vue'));
Vue.component('dark-mode-button', require('Public/components/DarkModeButton.vue'));
Vue.component('right-controls', require('Public/components/RightControls.vue'));

Vue.component('controls', require('Public/components/Controls.vue'));
Vue.component('control-buttons', require('Public/components/ControlButtons.vue'));
Vue.component('tools', require('Public/components/Tools.vue'));
Vue.component('transposition', require('Public/components/Transposition.vue'));
Vue.component('font-sizer', require('Public/components/FontSizer.vue'));
Vue.component('media', require('Public/components/Media.vue'));

Vue.component('search', require('Public/pages/Search.vue'));


import { ApolloClient } from 'apollo-client'
import { createHttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'

var base_url = document.querySelector('#baseUrl').getAttribute('value');

// HTTP connexion to the API
const httpLink = createHttpLink({
  // You should use an absolute URL here
  uri: base_url + '/graphql',
})

const cache = new InMemoryCache()

// Create the apollo client
const apolloClient = new ApolloClient({
  link: httpLink,
  cache,
})

import VueApollo from 'vue-apollo'
Vue.use(VueApollo)

const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
})

// import Vuetify, {
//   VApp, // required
// //   VNavigationDrawer,
// //   VDataTable,
//   VContainer,
//   VLayout,
//   VFlex,
//   VCard,
//   VCardText,
// //   VTextField
// } from 'vuetify/lib'

// Vue.use(Vuetify, {
//   components: {
//     VApp,
//     // VNavigationDrawer,
//     // VDataTable,
//     VContainer,
//     VLayout,
//     VFlex,
//     VCard,
//     VCardText,
//     // VTextField
//   }
// })

const app = new Vue({
    el: '#app',
    apolloProvider
});