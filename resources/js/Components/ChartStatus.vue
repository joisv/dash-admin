<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue'

const props = defineProps({
   status: Array
})

onMounted(() => {
    const ctx = document.getElementById('myChartdoughnut');
    const data = {
    labels: props.status.map(item => item.status),
    datasets: [{
        label: ['Status'],
        data: props.status.map(item => item.count),
        backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
    }]
    };
    new Chart(ctx, {
        type: 'doughnut',
        data: data,
    });
})
</script>

<template>
        <canvas id="myChartdoughnut"></canvas>
</template>


