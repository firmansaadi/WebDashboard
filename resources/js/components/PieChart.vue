<template>
  <div>
    <canvas ref="pieChart"></canvas>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  setup() {
    const pieChart = ref(null);

    onMounted(() => {
      new Chart(pieChart.value, {
        type: 'pie',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [{
            label: 'Data One',
            backgroundColor: ['#f87979', '#a8e063', '#66b3ff', '#ffcc99', '#c45850', '#3e95cd', '#8e5ea2'],
            data: [40, 20, 12, 39, 10, 40, 39]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    });

    return {
      pieChart
    };
  }
};
</script>

<style scoped>
canvas {
  width: 100% !important;
  height: 400px !important;
}
</style>
