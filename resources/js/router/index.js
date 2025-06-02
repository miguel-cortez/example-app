import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/HomeComponent.vue';
import Prod from '../components/ProductoComponent.vue';
import ProdsCat from '../components/GraficoTotalProductosCategorias.vue';
import PreviewPdf from '../components/PreviewPdfFileComponent.vue';
const routes = [
    { path: '/dashboard/home', component: Home },
    { path: '/dashboard/productos', component: Prod, meta: { requiresAuth: true } },
    { path: '/dashboard/prods_cat', component: ProdsCat },
    { path: 
        '/dashboard/preview_pdf',
         component: PreviewPdf,
        meta: { requiresAuth: true },
     }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const loggedIn = () =>{
    return true;
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!loggedIn()) {
      next({
        path: '/login',
        //query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})



export default router;