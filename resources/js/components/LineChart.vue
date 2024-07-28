<template>
  <div>
    <canvas ref="lineChart"></canvas>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  setup() {
    const lineChart = ref(null);

    onMounted(() => {
      new Chart(lineChart.value, {
        type: 'line',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [{
            label: 'Data One',
            backgroundColor: '#f87979',
            borderColor: '#f87979',
            data: [40, 20, 12, 39, 10, 40, 39],
            fill: false
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    });

    return {
      lineChart
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
