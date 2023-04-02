import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

//import VueFriendlyIframe from 'vue-friendly-iframe';
import routes from './routes.js';

import 'material-design-icons-iconfont/dist/material-design-icons.css'
//import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCocktail,faSearch, faSlash, faGlassMartiniAlt, faFillDrip, faBlender, faMugHot, faGlassWhiskey,faRedo,faLightbulb,faCompass,faPencilAlt} from '@fortawesome/free-solid-svg-icons'
import {faYoutube,faTwitter} from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faCocktail,faSearch, faSlash, faGlassMartiniAlt, faFillDrip, faBlender, faMugHot, faGlassWhiskey,faRedo,faLightbulb,faCompass,faPencilAlt,faYoutube,faTwitter)

import VueHead from 'vue-head'

window.Vue = require('vue');
require('./bootstrap')

Vue.use(VueRouter)
Vue.use(Vuetify);
//Vue.use(require('vue-script2'))

//Vue.component('vue-friendly-iframe', VueFriendlyIframe);
Vue.use(VueHead,{
    complement: '宅飲みカクテルデータベース(RC)',
    separator: '｜',
})
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.config.productionTip = false

const opts = {
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },}
const vuetify = new Vuetify();
const vueHead = new VueHead();

export default new Vuetify(opts)


const router = new VueRouter({
    mode: 'history',
    //base: process.env.BASE_URL,
    routes: routes(),
    scrollBehavior (to, from, savedPosition) {
        // 望みのポジションを返す
        if(to.name === from.name && to.name ==="CategoryDetail"){
            return
        }
        return { x: 0, y: 0 }
    }
});

const app = new Vue({
    store,
    router,
    el: '#app',
    vuetify,
    vueHead
})
