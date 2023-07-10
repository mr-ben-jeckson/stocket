import { createApp } from 'vue'
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import './index.css';
import './style.css';
//prime vue
//theme
import "./assets/theme.css";
//core
import "primevue/resources/primevue.min.css";
//icons
import "primeicons/primeicons.css";
import store from './store';
import router from './router';
import App from './App.vue'

createApp(App)
    .use(store)
    .use(router)
    .use(PrimeVue)
    .use(ToastService)
    .use(ConfirmationService)
    .mount('#app')
