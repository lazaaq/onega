import { createApp } from 'vue'
// import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './axios'
import store from './vuex'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/css/main.css'

const app = createApp(App)

app.config.globalProperties.$appHost = 'http://localhost:8080/#/';

app.use(router)
app.use(store)
app.mount('#app')