<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import ChartViews from '../Components/ChartViews.vue'
import ChartStatus from '../Components/ChartStatus.vue'
import Datatables from '../Components/Datatables.vue'
import Tab from '../Components/Tab.vue'

const headers = ['number','title', 'views']
const tabs = ['series', 'episodes']
const tabsV = ['series', 'episodes']
const activeTab = ref(tabs[0])
const activeTabV = ref(tabsV[0])
const props = defineProps({
    dates: {
        type: Array,
        default: () => ({})
    },
    dateseps: {
        type: Array,
        default: () => ({})
    },
    views: {
        type: Array,
        default: () => ({})
    },
    viewseps: {
        type: Array,
        default: () => ({})
    },
    new: {
        type: Array,
        default: () => ({})
    },
    status: {
        type: Array,
        default: () => ({})
    },
    totalViews: {
        type: String,
        default: () => ({})
    },
    totalViewsEps: {
        type: Array,
        default: () => ({})
    },
    popularVSeries: {
        type: Array,
        default: () => ({})
    },
    popularVEpisodes: {
        type: Array,
        default: () => ({})
    }
})
const setActiveTab = ( tab ) => {
    activeTab.value = tab
}
const setActiveTabV = ( tab ) => {
    activeTabV.value = tab
}
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
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg p-3">
                    <div class="flex mb-5">
                        <div class="flex space-x-5">
                            <!-- total views -->
                            <div class="bg-primaryBtn rounded-md p-4 flex flex-col justify-center">
                                <p class="text-secondaryBtn font-medium text-center text-lg">{{ totalViews }}</p>
                                <h2 class="text-secondaryBtn text-sm font-medium">Total Views Series</h2>
                            </div>
                            <div class="bg-primaryBtn rounded-md p-4 flex flex-col justify-center">
                                <p class="text-secondaryBtn font-medium text-center text-lg">{{ totalViewsEps }}</p>
                                <h2 class="text-secondaryBtn text-sm font-medium">Total Views Episode</h2>
                            </div>
                        </div>
                    </div>
                    <div class="md:flex sm:justify-between">
                        
                        <div class="md:w-[60%] w-full">
                            <Tab :tabs="tabs" :setActiveTab="setActiveTab" :activeTab="activeTab"/>
                            <div v-if="activeTab === 'series'">
                                <ChartViews :dates="props.dates" :views="props.views"/>
                            </div>
                            <div v-if="activeTab === 'episodes'">
                                <ChartViews :dates="props.dateseps" :views="props.viewseps"/>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 sm:w-[38%]">
                            <h1 class="font-semibold">Oder by popular</h1>
                            <Tab :tabs="tabsV" :setActiveTab="setActiveTabV" :activeTab="activeTabV" />
                            <div v-if="activeTabV === 'series' ">
                                <Datatables :headers="headers">
                                    <template v-for="(item, index ) in props.popularVSeries">
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
                            <div v-if="activeTabV === 'episodes'">
                                <Datatables :headers="headers">
                                    <template v-for="(item, index ) in props.popularVEpisodes">
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
                        </div>
                    </div>
                    <div class="sm:flex mt-10">
                        <!-- new post -->
                        <div class="sm:w-[90%]">
                            <h1 class="font-semibold">Oder by cerated at</h1>
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


