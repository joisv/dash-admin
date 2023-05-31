<script setup>
import { ref, watch } from 'vue'
import { useForm} from '@inertiajs/vue3';
import axios from 'axios';

import SearchInput from '../../Components/SearchInput.vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import DataTables from '../../Components/DataTables.vue';
import ButtonComponent from '../../Components/ButtonComponent.vue';
import Pagination from '../../Components/Pagination.vue';
import WarningSvg from '../../Components/WarningSvg.vue';
import InputForm from '../../Components/InputForm.vue'

const props = defineProps({ 
    series: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
 })


const headers = ref (['number', 'Title', 'Oiginal title', 'status', 'Actions' ])
const status = {
    complete: 'bg-green-600',
    pending: 'bg-accent',
    ongoing: 'bg-blue-700'
}
const flash = ref(true)
const form = useForm({})
let search = ref(props.filters.search);

watch(search, (value)=> {
    form.get(route('series.index', 
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    ))
})

const submit = () => {
    form.get(route('series.create'))
}


function handleFlash() {
    flash.value = false
}

function destroy(id) {
    if(confirm('are you sure?')){
        form.delete(route('series.destroy', id));
    }
}
function edit(id) {
    form.get(route('series.edit', id));
}
</script>



<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                    Series
                </h2>
            </div>
            <div class="max-w-7xl relative z-40">
                <button @click="handleFlash" class="absolute right-20" v-if="flash">
                    <div v-if="$page.props.flash.message" class="bg-secondaryBtn border-2 border-blue-300 rounded-md p-4 bg-opacity-90 text-gray-700 flex items-center space-x-4">
                        <WarningSvg />
                        <h1>{{ $page.props.flash.message }}</h1>
                    </div>
                </button>
            </div>
        </template>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <div class="flex justify-between items-center space-x-3 sm:space-x-10">
                        <form @submit.prevent="submit">
                            <ButtonComponent 
                                class="bg-primaryBtn hover:bg-slate-800 focus:ring-4 focus:ring-slate-300"
                                children="Add Series"
                                type="submit"
                            />
                        </form>
                        <SearchInput 
                            v-model="search"
                            placeholder="search me..."
                        />
                    </div>
                    <DataTables :headers="headers">
                        <template v-for="(item, index ) in series.data">
                            <tr class="bg-secondaryBtn border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ index + 1 }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ item.title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ item.original_title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="w-fit px-2 py-1 rounded-md text-secondaryBtn text-xs" :class="item.status === 'complete' ? status.complete : item.status === 'ongoing' ? status.ongoing : item.status === 'pending' ? status.pending : null">{{ item.status }}</p>
                                    </td>
                                    <td class="px-6 py-4 flex space-x-2">
                                    <ButtonComponent 
                                            class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300"
                                            children="edit"
                                            type="button"
                                            @click="edit(item.id)"
                                    />
                                    <ButtonComponent 
                                            class="bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200"
                                            children="delete"
                                            type="button"
                                            @click="destroy(item.id)"
                                    />
                                    </td>
                            </tr>
                        </template>
                    </DataTables>
                </div>
                <Pagination :data="series"/>
            </div>
    </AppLayout>
</template>