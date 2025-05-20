<template>
    <div class="card">
      <div ref="myDiv">
        Contenido de mi div
        <router-link to= "/dashboard/producto" class="btn btn-danger">Producto</router-link>
      </div>
    </div>
</template>

<script>
    import { ref, onMounted, useTemplateRef } from 'vue';
    import { defineExpose } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional
const myDiv = ref(null);
export default {
      setup() {
        onMounted(() => {
          //myDiv.value = useTemplateRef(myDiv);
          getProductos();
          myDiv.value = "UNO"
        });

        return {
          myDiv,
        }
      }
}

const getProductos = async () => {
  try {
    //const response = await axios.get("/api/dashboard/productos");
    const response = await axios.get("http://localhost:8000/api/dashboard/productos");
    //products.value = response.data
    //console.log(products.value)
    console.log(response.data);
    
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
