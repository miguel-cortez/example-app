<template>
    <div class="flex flex-row">
        <header>
        <div @click="toggle" class="bg-violet-600 text-lime-400 cursor-pointer p-4">
            <span class="pi pi-bars pl-2"></span><span class="pl-2 pr-2">MENU</span>
        </div>
        <nav :class="{'hidden' : isVisible}">
            <ul>
                <li><router-link to="/dashboard/home" class="btn btn-success">Home</router-link></li>
                <li><router-link to="/dashboard/productos">Productos</router-link></li>
            </ul>
        </nav>
        </header>
        <section class="bg-white">
            <router-view></router-view>
        </section>
    </div>
</template>
<script setup>
import { ref } from 'vue'

const isVisible = ref(false)

const toggle = () => {
  isVisible.value = !isVisible.value
}

</script>

<style scoped>

</style>