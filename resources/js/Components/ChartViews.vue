<script setup>
import Chart from 'chart.js/auto';
import { onMounted } from 'vue'

const props = defineProps({
    dates: Array,
    views: Array
})
onMounted(() => {
    const ctx = document.getElementById('myChart');
        new Chart(ctx, {
        type: 'bar',
        data: {
        labels: props.dates,
        datasets: [{
            label: 'views',
            data: props.views,
            backgroundColor: [
            'rgba( 143, 13, 249, 0.65 )',
            'rgba( 12, 188, 250, 0.65 )',
            'rgba( 185, 243, 0, 0.58 )',
            ],
            borderWidth: 1,
            borderRadius: 5
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
})
</script>

<template>
        <canvas id="myChart"></canvas>
</template>


