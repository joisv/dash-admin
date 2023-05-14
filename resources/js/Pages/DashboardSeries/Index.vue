<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';

import SearchInput from '../../Components/SearchInput.vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import DataTables from '../../Components/DataTables.vue';
import ButtonComponent from '../../Components/ButtonComponent.vue';

defineProps({ series: Array })
const headers = ref ([ 'Title', 'Oiginat title', 'Type', 'Actions' ])
const searchResult = ref([])
const form = useForm({})

const submit = () => {
    form.get(route('series.create'))
}

function handleSearchUpdated( result ){
    searchResult.value = result
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                Series
            </h2>
        </template>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <div class="flex justify-between items-center">
                        <form @submit.prevent="submit">
                            <ButtonComponent 
                                class="bg-accent font-medium"
                                children="New Series"
                                type="submit"
                            />
                        </form>
                        <SearchInput 
                            @search-updated="handleSearchUpdated"
                        />
                    </div>
                    <DataTables 
                        :series="series"
                        :headers="headers"
                    />
                    <Modal />
                </div>
            </div>
    </AppLayout>
</template>