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
        roles: ['administrador'] 
      }
    },
    { 
      path: '/dashboard/prods_cat', 
      component: ProdsCat 
    },
    { 
      path: '/dashboard/preview_pdf',
      component: PreviewPdf,
      meta:
      { requiresAuth: true 

      }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const logeado = () => {
  if(localStorage.getItem("infoUser") != null)
    return true;
  else
    return false;
}

const accesoConcedido = (rolesPermitidos) => {
    // Ejemplos
    
    // rolesPermitidos['estandar','administrador']
    // user.value.roles['reporteador','bodeguero','estandar']

    // Retorno. La función retorna true si el usuario tiene algún rol pemitido.

    var usuarioAutenticado = JSON.parse(localStorage.getItem("infoUser"))
    var resultado = false
    if(usuarioAutenticado.roles != null){
        rolesPermitidos.forEach(element => {
            let dato = usuarioAutenticado.roles.find(el => el === element);
            if(dato != null)
                resultado = true;
        });
    }
    return resultado
}

router.beforeEach((to, from, next) => {
  console.log("entrando")
  console.log(logeado())
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!accesoConcedido(to.meta.roles)) {
      router.push({ name: 'home' })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})



export default router;