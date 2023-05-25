<script setup>

import { useForm } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';
import InputForm from '../../Components/InputForm.vue';
import ButtonComponent from '../../Components/ButtonComponent.vue';
import InputError from '../../Components/InputError.vue'

const props = defineProps({
    episodes: {
        type: Object,
        default: () => ({})
    },
    series: {
        type: Object,
        default: () => ({}),
    }
})
const form = useForm({
    title: props.episodes.title,
    series_id: props.episodes.series.id,
    resolutions: props.episodes.resolutions
})

const addResolutions = () => {
    form.resolutions.push({
        resolution: '',
        url: '',
        download_url: ''
    });
}

const removeResolutons = (index) => {
    form.resolutions.splice(index, 1);
}

const update = (id) => {
    form.put(route('episodes.update', id))
}


</script>

<template>
    <AppLayout title="Add episodes">
        <template #header>
            <div class="w-full flex items-center justify-center">
                <div class="max-w-3xl h-full w-full">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                        Update episode
                    </h2>
                </div>
            </div>
        </template>
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h1 class="text-lg font-medium text-gray-400" v-if="!form.title">e.g Eps 21: My Own Steel..</h1>
                            <h1 class="text-lg font-medium text-primaryBtn" v-if="form.title">{{ form.title }}</h1>
                        </div>
                    </div>
                    <form @submit.prevent="update(episodes.id)">
                        <InputForm 
                            title="Title"
                            :required="true"
                            type="text"
                            v-model="form.title"
                            
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                        <label :for="ids" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Which series and episode?</label>
                        <select :id="ids" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        ref="input"
                        v-model="form.series_id"
                        
                        >
                            <template v-for="value in series">
                                <option :value="value.id">{{ value.title }}</option>
                            </template>
                        </select>
                        <InputError class="mt-2" :message="form.errors.series_id" />
                        <ButtonComponent 
                                class="bg-accent hover:bg-slate-500 focus:ring-4 focus:ring-orange-200 block"
                                children="add res"
                                type="button"
                                @click="addResolutions"
                                />
                        <template v-for="(resolution, index) in form.resolutions">
                            <div class="flex justify-between items-center space-x-3 w-full">
                                <div class="mb-6">
                                    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Resolutions</label>
                                    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="720p"
                                        v-model="resolution.resolution"
                                        :aria-label="`resolution ${index +1 } resolution`"
                                    >
                                </div>
                                <div class="mb-6 w-[75%]">
                                    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">url</label>
                                    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="https://ia801400.us.archive.org/0/items/od-engksj2829nc/od-engksj2829nc-hd-11.mp4"
                                        v-model="resolution.url"
                                        :aria-label="`resolution ${index + 1} url`"
                                    >
                                </div>
                                <div class="mb-6 w-[75%]">
                                    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">download url</label>
                                    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="nullable"
                                        v-model="resolution.download_url"
                                        :aria-label="`download_url ${index + 1} url`"
                                    >
                                </div>
                                <ButtonComponent 
                                    class="bg-red-400 hover:bg-red-500 focus:ring-4 focus:ring-red-300 h-fit"
                                    children="del"
                                    type="button"
                                    @click="removeResolutons(index)"
                                    />
                            </div>
                        </template>
                        <ButtonComponent 
                            class="bg-primaryBtn hover:bg-slate-800 focus:ring-4 focus:ring-slate-300"
                            children="update"
                            type="submit"
                        />
                    </form>

                 </div>   
            </div>   
    </AppLayout>
</template>