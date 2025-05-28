<template>
    <div class="card">
        <DataTable :value="productos" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <Column field="id" header="ID" style="width: 25%"></Column>
            <Column field="nombre" header="Nombre" style="width: 25%"></Column>
            <Column field="stock" header="Stock" style="width: 25%"></Column>
            <Column field="precio" header="Precio" style="width: 25%"></Column>
            <Column header="&nbsp;" style="min-width: 12rem">
                <template #body="slotProps">
                    <Button icon="pi pi-file-pdf" v-tooltip.top="'Ver ficha técnica'" severity="warn" @click="cargarPdf(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
    </div>
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
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';


const productos = ref([]);
const url = ref(null)

const cargarPdf = async (data) =>{
    if(data != null){
        url.value = data.ficha_tecnica
    }
}
const getFichasTecnicas = async () => {
  try {
    const response = await axios.get("/api/dashboard/productos/fichas_tecnicas");
    productos.value = response.data
  } catch (err) {
    console.error(err);
  }
};
onMounted(
    getFichasTecnicas(),    
    cargarPdf()
)
</script>