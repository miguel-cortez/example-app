<template>
    <div class="flex flex-row">
        <header>
        <div class="bg-teal-500 h-10">
            <a href="javascript:toggle()"> <span class="pi pi-bars pl-2"></span><span class="pl-2 pr-2">MENU</span></a>
        </div>
        <nav :class="{'hidden' : esOculto}">
            <ul>
                <li><router-link to="/dashboard/home" class="btn btn-success">Home</router-link></li>
                <li><router-link to="/dashboard/producto">Productos</router-link></li>
            </ul>
        </nav>
        </header>
    <section class="bg-white">
        <router-view></router-view>
    </section>
    </div>


    <div class="card">
        <Menubar :model="items" />
    </div>
</template>
<script setup>
import { ref } from 'vue'
import Menubar from 'primevue/menubar';
const esOculto = ref(false)

const items = ref([
    {
        label: 'Home',
        icon: 'pi pi-home'
    },
    {
        label: 'Features',
        icon: 'pi pi-star'
    },
    {
        label: 'Projects',
        icon: 'pi pi-search',
        items: [
            {
                label: 'Components',
                icon: 'pi pi-bolt'
            },
            {
                label: 'Blocks',
                icon: 'pi pi-server'
            },
            {
                label: 'UI Kit',
                icon: 'pi pi-pencil'
            },
            {
                label: 'Templates',
                icon: 'pi pi-palette',
                items: [
                    {
                        label: 'Apollo',
                        icon: 'pi pi-palette'
                    },
                    {
                        label: 'Ultima',
                        icon: 'pi pi-palette'
                    }
                ]
            }
        ]
    },
    {
        label: 'Contact',
        icon: 'pi pi-envelope'
    }
]);

</script>

<style scoped>

</style>