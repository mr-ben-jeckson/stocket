import { createApp } from 'vue'
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import './index.css';
import './style.css';
import store from './store';
import router from './router';
import App from './App.vue'

createApp(App)
    .use(store)
    .use(router)
    .use(PrimeVue)
    .use(ToastService)
    .mount('#app')
