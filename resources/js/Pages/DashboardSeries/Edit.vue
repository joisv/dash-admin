<script setup>
import { useForm } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';
import InputForm from '../../Components/InputForm.vue';
import SelectInput from '../../Components/SelectInput.vue'
import InputImgSvg from '@/Components/InputImgSvg.vue'
import ButtonComponent from '@/Components/ButtonComponent.vue'

const props = defineProps({
    series: {
        type: Object,
        default: () => ({})
    },
    genres: {
        type: Object,
        default: () => ({})
    },
});
console.log(props.series);
const options = ['Movie', 'Tv']
const status = ['ongoning', 'complete', 'pending']
const form = useForm({
    title: props.series.title,
    original_title: props.series.original_title,
    type: props.series.type,
    score: props.series.score,
    genres: props.series.genres,
    image: props.series.image,
    status: props.series.status,
    synopsis: props.series.synopsis
})
const submit = () => {
    form.put(route('series.update', props.series.id))
}
console.log(form.genres[0]);

</script>

<template>
    <AppLayout title="Edit">
        <template #header>
            <div class="w-full flex items-center justify-center">
                <div class="max-w-3xl h-full w-full">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                        Create new series 
                    </h2>
                </div>
            </div>
        </template>
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <div class="mb-4 flex items-center space-x-4">
                        <img class="rounded-full  h-14 w-14 sm:h-16 sm:w-16" src="https://flowbite.com/docs/images/examples/image-4@2x.jpg" v-if="!imagePreview">
                        <img :src="imagePreview" v-if="imagePreview" class="rounded-full h-16 w-16 sm:h-16 sm:w-16 object-cover object-top">
                        <div>
                            <h1 class="text-lg font-medium text-primaryBtn" v-if="!form.title">Youre title here...</h1>
                            <h1 class="text-lg font-medium text-primaryBtn" v-if="form.title">{{ form.title }}</h1>
                        </div>
                    </div>
                    <form @submit.prevent="submit">
                        <InputForm 
                            title="Title"
                            :required="true"
                            type="text"
                            v-model="form.title"
                            
                        />
                        <InputForm 
                            title="Original_title"
                            :required="false"
                            type="text"
                            v-model="form.original_title"
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                        <div class="flex w-full justify-between space-x-3 mb-4">
                            <div class="flex items-center justify-center md:w-[35%] w-[50%]">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-36 sm:h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 p-2">
                                        <InputImgSvg />
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" v-on:change="handleImage" />
                                    <InputError class="mt-2" :message="form.errors.image" />
                                </label>
                            </div >
                            <div class="w-full">
                                <SelectInput 
                                    v-model="form.type"
                                    :values="options"
                                    title="Types"
                                    ids="type"
                                />
                                <InputForm 
                                    title="Score"
                                    :required="true"
                                    type="text"
                                    v-model="form.score"
                                />
                            </div>
                           
                        </div>
                        
                        <InputError class="mt-2" :message="form.errors.score" />
                        <SelectInput 
                            v-model="form.status"
                            title="Status"
                            :values="status"
                            ids="status"
                        />
                        <div class="w-full h-28 overflow-auto mb-4 border-2 border-gray-200 rounded-md p-2 flex flex-wrap space-x-2">
                            <template v-for="( genre, index ) in genres" :key="genre.id">
                                <div class="p-1 w-fit h-fit border-2 border-gray-400 rounded-md ">
                                     <input type="checkbox" :name="`genres${index+1}`" :id="`genres${index+1}`" class="opacity-50 absolute" 
                                     :value="genre.id" 
                                     v-model="form.genres" 
                                     :checked="form.genres.includes(genre.id)">

                                     <label :for="`genres${index+1}`" class="px-2 py-1 font-medium text-primaryBtn">{{ genre.names }}</label>
                                </div>
                            </template>
                        </div>
                        <InputError class="mt-2" :message="form.errors.status" />
                        <div class="w-full mb-4 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="px-4 py-2 bg-secondaryBtn rounded-t-lg dark:bg-gray-800">
                                <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-secondaryBtn border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a synopsis..." v-model="form.synopsis"></textarea>
                            </div>
                        </div>
                        <ButtonComponent 
                            class="bg-primaryBtn hover:bg-slate-800 focus:ring-4 focus:ring-slate-300"
                            children="Save"
                            type="submit"
                        />
                    </form>

                 </div>   
            </div>   
    </AppLayout>
</template>