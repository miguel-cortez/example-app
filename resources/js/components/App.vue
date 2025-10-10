<template>
        <Menubar :model="items">
            <template #item="{ item, props, hasSubmenu }">
                <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                    <a v-if="accesoConcedido(item.roles)" v-ripple :href="href" v-bind="props.action" @click="navigate">
                        <span :class="item.icon" />
                        <span>{{ item.label }}</span>
                    </a>
                </router-link>
                <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                    <span :class="item.icon" />
                    <span>{{ item.label }}</span>
                    <span v-if="hasSubmenu" class="pi pi-fw pi-angle-down" />
                </a>
            </template>
        </Menubar>
    <router-view></router-view>

    <br />
    <h1>Prueba de credenciales</h1>
    <div v-if="credenciales.user">USUARIO: {{ credenciales.user.email }}</div>
    <Button :onClick="borrarCredenciales">Borrar credenciales</Button>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import Menubar from 'primevue/menubar';

const router = useRouter();

const credenciales = ref({})

const items = ref([
    {
        label: 'Catálogos',
        icon: 'pi pi-book',
        items: [
            {
                label: 'Productos',
                icon: 'pi pi-tag',
                route: '/dashboard/productos',
                roles: ['estandar','administrador']  // AGREGADA MACV
            }
        ]
    },
    {
        label: 'Transacciones',
        icon: 'pi pi-slack',
        items: [
            {
                label: 'Vue.js',
                url: 'https://vuejs.org/',
                roles: ['estandar']  // AGREGADA MACV
            },
            {
                label: 'Vite.js',
                url: 'https://vitejs.dev/',
                roles: ['estandar']  // AGREGADA MACV
            }
        ]
    },
    {
        label: 'Informes',
        icon: 'pi pi-chart-bar',
        items: [
            {
                icon: 'pi pi-slack',
                label: 'Productos por categoría',
                route: '/dashboard/prods_cat',
                roles: ['estandar','supervisor']  // AGREGADA MACV
            },
            {
                icon: 'pi pi-eye',
                label: 'Preview Pdf',
                route: '/dashboard/preview_pdf',
                roles: ['administrador']  // AGREGADA MACV
            },
        ]
    },
    {
        label: 'Ayuda',
        icon: 'pi pi-question-circle',
        command: () => {
            router.push('/introduction');
        }
    },
]);

const getCredenciales = async () => {
    const cred = localStorage.getItem("credenciales");
    if(cred == null ){
      axios.post('/getcredenciales')
      .then(response => {
        localStorage.setItem("credenciales", JSON.stringify(response.data));
        credenciales.value = response.data;
        // Acceder a datos personales: credenciales.user.name
        // Acceder a los permisos directos: credenciales.user.permissions
        // Acceder a los roles: credenciales.user.roles
        // Acceder a los permisos vinculados con el primer rol: credenciales.user.roles[0].permissions
        // Acceder a al primer permiso vinculado con el primer rol del usuario: credenciales.user.roles[0].permissions[0]
        // Acceder a los permisos vinculados con el primer rol: credenciales.user.roles[1].permissions
        // Acceder a al primer permiso vinculado con el segundo rol del usuario: credenciales.user.roles[1].permissions[0]
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }else{
        credenciales.value = JSON.parse(cred);
    }
}

const accesoConcedido = (rolesPermitidos) => {
    // Ejemplos
    
    // rolesPermitidos['estandar','administrador']
    // user.value.roles['reporteador','bodeguero','estandar']

    // Retorno. La función retorna true si el usuario tiene algún rol pemitido.

    var resultado = false
    if(credenciales.value.user != null){
        rolesPermitidos.forEach(element => {
            let dato = credenciales.value.user.roles.find(el => el.name === element);
            if(dato != null){
                resultado = true;
            }
        });
    }
    return resultado
}

const borrarCredenciales = () => {
    const cred = localStorage.getItem("credenciales");
    console.log("Borrando credenciales")
    if(cred != null ){
        localStorage.removeItem("credenciales");
        credenciales.value.user = null
        console.log("Credenciales borradas")
    }
}

onMounted(() => {
    console.log("onMounted")
    getCredenciales()
})

</script>

<style scoped>

</style>