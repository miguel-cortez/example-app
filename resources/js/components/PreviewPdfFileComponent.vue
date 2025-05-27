<template>
    <div class="card flex flex-col items-center gap-4">
    <Panel>
    <iframe :src="url" width="800" height="600" style="border: none;">
    </iframe>
    </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Panel from 'primevue/panel';
const url = ref(null)
const cargarPdf = () =>{
    url.value = "/documentos/ArchivoXYZ.pdf"
}
onMounted(
    cargarPdf
)
</script>