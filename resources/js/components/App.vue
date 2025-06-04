<template>
    <div class="card py-4">
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
    </div>
    <router-view></router-view>
    <div>USUARIO: {{ usuarioAutenticado.roles }}</div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import Menubar from 'primevue/menubar';

const router = useRouter();

const usuarioAutenticado = ref({})

const items = ref([
    {
        label: 'Catálogos',
        icon: 'pi pi-book',
        items: [
            {
                label: 'Productos',
                icon: 'pi pi-tag',
                route: '/dashboard/productos',
                roles: ['administrador']  // AGREGADA MACV
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
                roles: ['estandar']  // AGREGADA MACV
            },
            {
                icon: 'pi pi-eye',
                label: 'Preview Pdf',
                route: '/dashboard/preview_pdf',
                roles: ['estandar']  // AGREGADA MACV
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

const getInfoUser = async () => {
    // localStorage.clear();

    /*
    const infoUser = localStorage.getItem("infoUser");
    if(infoUser == null ){
      axios.post('/getuser')
      .then(response => {
        //console.log(response.data)
        console.log(response.data.user)
        console.log(response.data.roles)
        console.log(response.data.rolesPermissions)
        console.log(response.data.directPermissions)
        localStorage.setItem("infoUser", JSON.stringify(response.data));
        usuarioAutenticado.value = response.data;
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }else{
        usuarioAutenticado.value = JSON.parse(infoUser);
        //console.log(user.value.roles[0])
    }
    */
}

onMounted(() => {
  getInfoUser()
})

const accesoConcedido = (rolesPermitidos) => {
    // Ejemplos
    
    // rolesPermitidos['estandar','administrador']
    // user.value.roles['reporteador','bodeguero','estandar']

    // Retorno. La función retorna true si el usuario tiene algún rol pemitido.

    var resultado = false
    if(usuarioAutenticado.value.roles != null){
        rolesPermitidos.forEach(element => {
            let dato = usuarioAutenticado.value.roles.find(el => el === element);
            if(dato != null)
                resultado = true;
        });
    }
    return resultado
}

</script>

<style scoped>

</style>