<script setup>
import { ref, watch } from 'vue'
import { useForm} from '@inertiajs/vue3';

import SearchInput from '../../Components/SearchInput.vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import DataTables from '../../Components/DataTables.vue';
import ButtonComponent from '../../Components/ButtonComponent.vue';
import Pagination from '../../Components/Pagination.vue';

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
 console.log(props.series);

const headers = ref ([ 'Title', 'Oiginat title', 'Type', 'Actions' ])
const searchResult = ref([])
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

function handleSearchUpdated( result ){
    searchResult.value = result
}
function handleFlash() {
    flash.value = false
}

</script>



<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                Series
            </h2>
            <button @click="handleFlash" v-if="flash">
                <div v-if="$page.props.flash.message" class="bg-primaryBtn rounded-md p-4 bg-opacity-90 text-secondaryBtn">
                    {{ $page.props.flash.message }}
                </div>
            </button>
        </template>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <div class="flex justify-between items-center space-x-3 sm:space-x-10">
                        <form @submit.prevent="submit">
                            <ButtonComponent 
                                class="bg-accent font-medium text-sm sm:text-base text-secondaryBtn"
                                children="Add Series"
                                type="submit"
                            />
                        </form>
                        <SearchInput 
                            v-model="search"
                        />
                    </div>
                    <DataTables 
                        :series="series"
                        :headers="headers"
                    />
                </div>
                <Pagination :data="series"/>
            </div>
    </AppLayout>
</template>