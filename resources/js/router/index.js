import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/HomeComponent.vue';
import Prod from '../components/ProductoComponent.vue';
import ProdsCat from '../components/GraficoTotalProductosCategorias.vue';
import PreviewPdf from '../components/PreviewPdfFileComponent.vue';
const routes = [
    { path: '/dashboard/home', component: Home },
    { path: '/dashboard/productos', component: Prod },
    { path: '/dashboard/prods_cat', component: ProdsCat },
    { path: '/dashboard/preview_pdf', component: PreviewPdf }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;