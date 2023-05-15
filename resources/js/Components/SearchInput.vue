<script setup>
import { ref } from 'vue'
import { debounce } from 'lodash'
import axios from 'axios';

const searchQuery = ref('');
const searchResult = ref([]);
const emit = defineEmits(['search-updated']);

const search = debounce(() => {
    axios.get('/search', { params: { searchQuery: searchQuery.value } })
    .then(response => {
        searchResult.value = response.data;
        emit('search-updated', searchResult.value)
    })
    .catch(error => {
      console.error('SearchInput',error);
    });
}, 300)

const handleSearch = () => {
    search()
}
</script>

<template>
    <div class="relative w-1/2">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Mockups, Logos..." v-model="searchQuery" @input="handleSearch">
    </div>
</template>