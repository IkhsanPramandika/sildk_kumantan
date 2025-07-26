<template>
  <div>
    <h3 v-if="title" class="text-lg font-semibold mb-2">{{ title }}</h3>
    <Bar :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import { Chart, BarElement, CategoryScale, LinearScale, Tooltip, Legend } from 'chart.js'
Chart.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend)

const props = defineProps({
  labels: Array,
  values: Array,
  title: String
})

const chartData = {
  labels: props.labels,
  datasets: [
    {
      label: props.title || '',
      backgroundColor: '#e11d48',
      data: props.values
    }
  ]
}

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { display: false }
  }
}
</script>
