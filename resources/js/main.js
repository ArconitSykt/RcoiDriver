require('./bootstrap');

import Vue from 'vue'
import App from './App'
import Vuetify from 'vuetify'
import axios from 'axios'
import router from './router'
import ru from 'vuetify/es5/locale/ru'
import 'vuetify/dist/vuetify.min.css'

const vuetifyOptions = {
    lang: {
        locales: { ru },
        current: 'ru'
    }
}
Vue.use(Vuetify)


Event = new Vue();


new Vue({
    el: '#app',
    axios,
    router,
    vuetify: new Vuetify(vuetifyOptions),
    components: { App },
    template: '<App/>'
}
)

