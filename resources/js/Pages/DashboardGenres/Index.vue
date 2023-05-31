<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';
import Pagination from '../../Components/Pagination.vue';
import WarningSvg from '../../Components/WarningSvg.vue';
import ButtonComponent from '../../Components/ButtonComponent.vue';
import SearchInput from '../../Components/SearchInput.vue';
import DataTables from '../../Components/DataTables.vue';

const props = defineProps({
    genres: {
        type: Array,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
   
})
const flash = ref(true)
const form = useForm({})
const headers = (['number','title', 'actions'])
let search = ref(props.filters.search);


watch(search, (value)=> {
    form.get(route('genres.index', 
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    ))
})
const isGenerate = ref(false)
const isError = ref(false)
const result = ref({})
const err = ref('')

const generate = useForm({
    name: []
})
const handleGenerate = async () => {
    isGenerate.value = true
    if (props.genres.data.length === 0) {
        try {
            const response = await axios.get(`/api/v1/genres/anime/generate`);
            result.value = response.data.data.data;
            console.log(result.value);
            result.value.map(item => {
                generate.name.push(item.name)
            })
            generate.post(route('generateme'))
            isGenerate.value = false
            isError.value = false
        } catch (error) {
            err.value = error
            isGenerate.value = false
            isError.value = true
        }
    } else {
        alert('reset genres first')
    }
};
const reset = () => {
    if(confirm('reset semua genre')){
        if (props.genres.data.length === 0){
           alert('no genres')
        } else {
            form.get(route('resetgenres'))
        }
    }
}

console.log(props.genres, err);
const submit = () => {
    form.get(route('genres.create'))
}
function handleFlash() {
    flash.value = false
}
function destroy(id) {
    if(confirm(`are you sure?`)){
        form.delete(route('genres.destroy', id));
    }
}
function edit(id) {
    form.get(route('genres.edit', id));
}
</script>

<template>
     <AppLayout title="Episodes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                Episodes
            </h2>
            <div>
                <div class="bg-red-300 p-2 rounded-sm text-medium" v-if="isError">
                    <h1>{{ err }}</h1>
                </div>
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
                            <div class="flex space-x-4">
                                <form @submit.prevent="submit">
                                    <ButtonComponent 
                                        class="bg-primaryBtn hover:bg-slate-800 focus:ring-4 focus:ring-slate-300"
                                        children="Add Genres"
                                        type="submit"
                                    />
                                </form>
                                <ButtonComponent 
                                    class="hover:bg-yellow-300 focus:ring-4 focus:ring-slate-300 h-fit"
                                    :class="isGenerate ? 'bg-yellow-400 ': 'bg-accent'"
                                    children="generate"
                                    type="submit"
                                    @click="handleGenerate()"
                                />
                                <ButtonComponent 
                                    class="bg-red-600 hover:bg-red-400 focus:ring-4 focus:ring-red-300 h-fit"
                                    children="reset"
                                    type="submit"
                                    @click="reset()"
                                />
                            </div>
                            <SearchInput 
                                v-model="search"
                                placeholder="serach me..."
                            />
                        </div>
                        <DataTables :headers="headers">
                        <template v-for="(item, index ) in genres.data">
                            <tr class="bg-secondaryBtn border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ index + 1 }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ item.names }}
                                    </th>
                                    <td class="px-6 py-4 flex space-x-2">
                                    <ButtonComponent 
                                            class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300"
                                            children="edit"
                                            type="submit"
                                            @click="edit(item.id)"
                                    />
                                    <ButtonComponent 
                                            class="bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200"
                                            children="delete"
                                            type="submit"
                                            @click="destroy(item.id)"
                                    />
                                    </td>
                            </tr>
                        </template>
                    </DataTables>
                </div>
                <Pagination :data="genres"/>
            </div>
     </AppLayout>
</template>