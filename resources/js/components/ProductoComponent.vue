<template>
    <div class="card">
        <DataTable :value="products" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <Column field="id" header="ID" style="width: 25%"></Column>
            <Column field="nombre" header="Nombre" style="width: 25%"></Column>
            <Column field="stock" header="Stock" style="width: 25%"></Column>
            <Column field="precio" header="Precio" style="width: 25%"></Column>
        </DataTable>
    </div>
</template>

<script setup>
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
    console.log(products.value)

    /*
      carreras.value = response.data;
      response.data.forEach((item, index) => {
        carreras.value[index].estado = (item.estado) == "A" ? "Activa": "Inactiva";
      })
    */
  } catch (err) {
    console.error(err);
  }
};
</script>