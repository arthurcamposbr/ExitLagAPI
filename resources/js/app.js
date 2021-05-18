//require('./bootstrap');
import Vue from 'vue'
import router from './routes'
import store from './store'
import i18n from './i18n'

Vue.config.productionTip = false

//Main pages
import App from './views/App.vue'

const app = new Vue({
    router,
    store,
    i18n,
    render: h => h(App)
}).$mount('#app');
