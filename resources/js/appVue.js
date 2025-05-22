import { createApp } from 'vue';
import App from './components/App3.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import Button from "primevue/button"
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import 'primeicons/primeicons.css';
import axios from 'axios'

const app = createApp(App);

app.config.globalProperties.$axios = axios;
window.axios = axios;

app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});
app.use(ToastService);

app.component('Button', Button);
app.component('Toast', Toast);
window.Vue = app;
app.mount('#app');