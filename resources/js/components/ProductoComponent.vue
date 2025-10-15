<template>
  <Toast />
    <div class="bg-amber-200 p-4">
        <DataTable :value="productos" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <Column field="id" header="ID" style="width: 25%"></Column>
            <Column field="nombre" header="Nombre" style="width: 25%"></Column>
            <Column field="stock" header="Stock" style="width: 25%"></Column>
            <Column field="precio" header="Precio" style="width: 25%"></Column>
            <Column field="imagen" header="Imagen" style="width: 25%"></Column>

            <Column class="w-24 !text-start">
              <template #body="{ data }">
                <Button v-if="data.imagen==null" icon="pi pi-cloud-upload" class="mr-5 mb-5" @click="selectRowUpload(data)" />
                <div v-else class="flex flex-row">
                  <Button icon="pi pi-eye" @click="selectRowPreview(data)" severity="info" class="mr-3"></Button>
                  <Button class="ml-2" icon="pi pi-trash" @click="selectRowRemove(data)" severity="danger" />
                </div>
              </template>
            </Column>
        </DataTable>
    </div>

    <Dialog v-model:visible="visible" modal header="Subir imágnes" :style="{ width: '26rem' }">
    <span class="text-surface-500 dark:text-surface-400 block mb-8">Seleccione una imagen a subir.</span>
    <div class="flex items-center gap-4 mb-8">
        <FileUpload
            name="image[]"
            url="/api/dashboard/productos/upload"
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

  <Dialog v-model:visible="preview" modal header="Vista previa" >
      <div class="flex items-center gap-4 mb-8">
          <img v-if="dataArchivoSeleccionado" :src="`https://res.cloudinary.com/dpj56vjfn/image/upload/v1760517019/images/productos/${dataArchivoSeleccionado.imagen.toLowerCase()}`" alt="Sin imagen" />
      </div>
      <div class="flex justify-end gap-2">
          <Button type="button" label="Cerrar" severity="secondary" @click="preview = false"></Button>
      </div>
  </Dialog>

</template>
<script setup>

const visible = ref(false);
const preview = ref(false);
const dataArchivoSeleccionado = ref();


import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const productos = ref([]);
const toast = useToast();

onMounted(() => {
  getProductos();
});

const getProductos = async () => {
  try {
    const response = await axios.get("/api/dashboard/productos");
    response.data.forEach((item,index) =>{
      productos.value.push( { id: item.id, nombre: item.nombre, stock: item.stock , precio: item.precio, imagen: item.imagen } )
    })
  } catch (err) {
    console.error(err);
  }
};

const onBeforeSend = (event) => {
  event.formData.append('producto_id', dataArchivoSeleccionado.value.id);
};

const onAdvancedUpload = (event) => {
    const obj = JSON.parse(event.xhr.response);
    console.log(obj)
    obj.data.forEach((item)=>{
        var index = productos.value.findIndex((a) => a.id == dataArchivoSeleccionado.value.id)
        if(index != -1)
        {
            productos.value[index].imagen = item
        }
    })
    toast.add({ severity: 'info', summary: 'Satisfactorio', detail: 'Archivo(s) subido(s)', life: 3000 });
};

const selectRowUpload = (data) => {
  visible.value = true;
  dataArchivoSeleccionado.value = { ...data } // para clonar el objeto que será mostrado en vista previa.
};


const selectRowRemove = async (data) => {
  try {
    const response = await axios.put("/api/dashboard/productos/remove",{"id":data.id});
    console.log(response.data)
    var index = productos.value.findIndex((a) => a.id == data.id)
    if(index != -1)
    {
      productos.value[index].imagen = null
    }
  } catch (err) {
    console.log(err)
  }
};

const selectRowPreview = async (data) => {
  dataArchivoSeleccionado.value = { ...data }
  preview.value = true
};
</script>