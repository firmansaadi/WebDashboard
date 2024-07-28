<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2>Bar Chart</h2>
        <BarChart />
      </div>
      <div class="col-md-6">
        <h2>Pie Chart</h2>
        <PieChart />
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-6">
        <h2>Line Chart</h2>
        <LineChart />
      </div>
      <div class="col-md-6">
        <h2>Doughnut Chart</h2>
        <DoughnutChart />
      </div>
    </div>
  </div>
</template>

<script>
import BarChart from '@/components/BarChart.vue';
import PieChart from '@/components/PieChart.vue';
import LineChart from '@/components/LineChart.vue';
import DoughnutChart from '@/components/DoughnutChart.vue';

export default {
  components: {
    BarChart,
    PieChart,
    LineChart,
    DoughnutChart
  }
};
</script>

<style>
.container {
  margin-top: 20px;
}
</style>
