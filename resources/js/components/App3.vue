
<template>
    <div class="card py-4">
        <Menubar :model="items">
            <template #item="{ item, props, hasSubmenu }">
                <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                    <a v-ripple :href="href" v-bind="props.action" @click="navigate">
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
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from 'vue-router';
import Menubar from 'primevue/menubar';

const router = useRouter();

const items = ref([
    {
        label: 'Catálogos',
        icon: 'pi pi-book',
        items: [
            {
                label: 'Productos',
                icon: 'pi pi-tag',
                route: '/dashboard/productos'
            },
            {
                label: 'Unstyled',
                route: '/theming/unstyled'
            }
        ]
    },
    {
        label: 'Transacciones',
        icon: 'pi pi-slack',
        items: [
            {
                label: 'Vue.js',
                url: 'https://vuejs.org/'
            },
            {
                label: 'Vite.js',
                url: 'https://vitejs.dev/'
            }
        ]
    },
    {
        label: 'Informes',
        icon: 'pi pi-chart-bar',
        items: [
            {
                label: 'Vue.js',
                url: 'https://vuejs.org/'
            },
            {
                label: 'Vite.js',
                url: 'https://vitejs.dev/'
            }
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
</script>

<style scoped>

</style>