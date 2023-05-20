<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ChartViews from '../Components/ChartViews.vue'
import ChartStatus from '../Components/ChartStatus.vue'
import Datatables from '../Components/Datatables.vue'

const props = defineProps({
    dates: Array,
    views: Array,
    new: Array,
    status: Array
})
const headers = ['number','title', 'views']
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg">
                    <ChartViews :dates="props.dates" :views="props.views"/>
                    <div class="sm:flex mt-10">
                        <!-- new post -->
                        <div class="sm:w-[90%]">
                            <Datatables :headers="headers">
                                <template v-for="(item, index ) in props.new">
                                    <tr class="bg-secondaryBtn border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ index + 1 }}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ item.title }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ item.views }}
                                            </td>
                                           
                                    </tr>
                                </template>
                            </Datatables>
                        </div>
                        <!-- status -->
                        <div class="mt-10 sm:mt-0">
                            <ChartStatus :status="props.status"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


