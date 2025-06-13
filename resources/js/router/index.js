import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/HomeComponent.vue';
import Prod from '../components/ProductoComponent.vue';
import ProdsCat from '../components/GraficoTotalProductosCategorias.vue';
import PreviewPdf from '../components/PreviewPdfFileComponent.vue';
const routes = [
    { 
      path: '/dashboard/home', 
      name: 'home',
      component: Home
    },
    {
      path: '/dashboard/productos', 
      component: Prod, 
      meta: { 
        requiresAuth: true,
        roles: ['estandar'] 
      }
    },
    { 
      path: '/dashboard/prods_cat', 
      component: ProdsCat,
      meta:
      {
        requiresAuth: true,
        roles: ['supervisor'] 
      }
    },
    { 
      path: '/dashboard/preview_pdf',
      component: PreviewPdf,
      meta:
      {
        requiresAuth: true,
        roles: ['administrador'] 
      }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const accesoConcedido = (rolesPermitidos) => {
    // Ejemplos
    
    // rolesPermitidos['estandar','administrador']
    // user.value.roles['reporteador','bodeguero','estandar']

    // Retorno. La función retorna true si el usuario tiene algún rol pemitido.

    var credenciales = JSON.parse(localStorage.getItem("credenciales"))
    var resultado = false
    if(credenciales.user != null){
        rolesPermitidos.forEach(element => {
            let dato = credenciales.user.roles.find(el => el.name === element);
            if(dato != null)
                resultado = true;
        });
    }
    return resultado
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!accesoConcedido(to.meta.roles)) {
      router.push({ name: 'home' })
    } else {
      next()
    }
  } else {
    next()
  }
})



export default router;