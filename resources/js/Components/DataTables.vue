<script setup>
import { defineProps } from 'vue';

defineProps({
    series: Array,
    headers: Array
})
</script>

<template>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-secondaryBtn dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <template v-for="header in headers">
                        <th scope="col" class="px-6 py-3">
                            {{ header }}
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template v-for="item in series" :key="series.id">
                <tr class="bg-secondaryBtn border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ item.title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ item.original_title }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.type }}
                        </td>
                        <td class="px-6 py-4">
                            Edit
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>