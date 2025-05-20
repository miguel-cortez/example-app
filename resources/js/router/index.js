import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/HomeComponent.vue';
import Prod from '../components/ProductoComponent.vue';

const routes = [
    { path: '/dashboard/home', component: Home },
    { path: '/dashboard/productos', component: Prod }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;