<template>
    <div class="bg-amber-200 p-4">
        <DataTable :value="products" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <Column field="id" header="ID" style="width: 25%"></Column>
            <Column field="nombre" header="Nombre" style="width: 25%"></Column>
            <Column field="stock" header="Stock" style="width: 25%"></Column>
            <Column field="precio" header="Precio" style="width: 25%"></Column>
        </DataTable>
    </div>

    <Button label="Subir documentos" class="mr-5 mb-5" @click="visible = true" />


    <Dialog v-model:visible="visible" modal header="Subir documentos" :style="{ width: '26rem' }">
    <span class="text-surface-500 dark:text-surface-400 block mb-8">Seleccione el documento a subir.</span>
    <div class="flex items-center gap-4 mb-8">
        <FileUpload
            name="image[]"
            url="/api/matricula/documento/upload"
            @before-send="onBeforeSend"
            @upload="onAdvancedUpload"
            :multiple="true"
            accept="image/*"
            :maxFileSize="1000000"
        />
    </div>
    <div class="flex justify-end gap-2">
        <Button type="button" label="Cerrar" severity="secondary" @click="visible = false"></Button>
    </div>
</Dialog>


</template>
<script setup>

const visible = ref(false);
const dataArchivoSeleccionado = ref();

import { ref, onMounted } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const products = ref([]);

onMounted(() => {
  getProductos();
});

const getProductos = async () => {
  try {
    const response = await axios.get("/api/dashboard/productos");
    products.value = response.data
  } catch (err) {
    console.error(err);
  }
};
</script>