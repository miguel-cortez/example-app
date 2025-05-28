import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import Button from "primevue/button"
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import 'primeicons/primeicons.css';
import axios from 'axios'
import Tooltip from 'primevue/tooltip';

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
app.directive('tooltip', Tooltip);
window.Vue = app;
app.mount('#app');