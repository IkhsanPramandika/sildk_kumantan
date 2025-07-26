<template>
  <div>
    <h3 v-if="title" class="text-lg font-semibold mb-2">{{ title }}</h3>
    <Pie :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { Pie } from 'vue-chartjs'
import { Chart, ArcElement, Tooltip, Legend } from 'chart.js'
Chart.register(ArcElement, Tooltip, Legend)

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
      backgroundColor: [
        '#e11d48', // red-600
        '#2563eb', // blue-600
        '#f59e42', // orange-400
        '#10b981', // green-500
        '#a21caf', // purple-800
        '#fbbf24', // yellow-400
        '#14b8a6', // teal-500
        '#6366f1'  // indigo-500
      ],
      data: props.values
    }
  ]
}

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { position: 'bottom' }
  }
}
</script>
