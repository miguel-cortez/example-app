<template>
    <div class="card">
        <Chart type="bar" :data="chartData" :options="chartOptions" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Chart from 'primevue/chart';
onMounted(() => {
    getCategorias()
});

const chartData = ref();
const chartOptions = ref();
const etiquetas = ref([])
const valores = ref([])

const setChartData = () => {
    return {
        labels: etiquetas,
        datasets: [
            {
                label: 'Productos por categoría',
                data: valores.value,
                backgroundColor: ['rgba(249, 115, 22, 0.2)', 'rgba(6, 182, 212, 0.2)', 'rgb(107, 114, 128, 0.2)', 'rgba(139, 92, 246 0.2)'],
                borderColor: ['rgb(249, 115, 22)', 'rgb(6, 182, 212)', 'rgb(107, 114, 128)', 'rgb(139, 92, 246)'],
                borderWidth: 1
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
    const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');

    return {
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}
const getCategorias = async () => {
  try {
    await axios.get("/api/dashboard/grafico_productos_categorias")
    .then(function (response) {
        response.data.forEach((item, index) => {
            etiquetas.value.push(item.nombre)
            valores.value.push(parseInt(item.total_productos))
        });
    })
    .catch(function (error) {
        console.log(error);
    })
    .finally(function () {
        chartData.value = setChartData();
        chartOptions.value = setChartOptions();
    });
  } catch (err) {
    console.error(err);
  }
};
</script>