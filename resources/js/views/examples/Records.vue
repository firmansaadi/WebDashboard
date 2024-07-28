<template>
  <div>
    <h3>Alarm</h3>
    <table>
      <thead>
        <tr>
          <th>Date Occur</th>
          <th>Time Occur</th>
          <th>Alarm Description</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(alarm, index) in alarms" :key="index">
          <td>{{ alarm.dateOccur }}</td>
          <td>{{ alarm.timeOccur }}</td>
          <td>{{ alarm.description }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'Records',
  data() {
    return {
      alarms: [
        { dateOccur: '1/1/2028', timeOccur: '3:10:00', description: 'Voltage is Under 180 Volt' },
        { dateOccur: '3/20/2028', timeOccur: '15:20:02', description: 'Reactive Power is too High' },
        { dateOccur: '8/2/2028', timeOccur: '9:00:56', description: 'Ampere Value is not usual' },
      ],
    };
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

thead {
  background-color: orange;
}

th, td {
  border: 1px solid black;
  padding: 8px;
  text-align: left;
}

th {
  font-weight: bold;
}
</style>
