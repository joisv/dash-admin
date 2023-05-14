<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watchEffect } from 'vue'

import AppLayout from '../../Layouts/AppLayout.vue';
import InputForm from '../../Components/InputForm.vue';
import InputError from '@/Components/InputError.vue';
import InputImgSvg from '@/Components/InputImgSvg.vue'

const isImage = ref(false);
const imagePreview = ref(null);
const form = useForm({
    title: '',
    type: '',
    score: '',
    image: null,
    status: '',
    synopsis: ''
});

watchEffect(() => {
    form.image != null ? isImage.value = true : isImage.value = false;
})

const handleImage = (event) => {
    form.image = event.target.files[0];
    if (form.image) {
      const reader = new FileReader();
      reader.onload = () => {
        imagePreview.value = reader.result;
      };
      reader.readAsDataURL(form.image);
    } else {
      imagePreview.value = null;
    }
}


const submit = () => {
    form.post(route('series.store'))
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                Create new series 
            </h2>
        </template>
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <form @submit.prevent="submit">
                        <InputForm 
                            title="Title"
                            :required="true"
                            type="text"
                            v-model="form.title"
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                        <div class="flex w-full justify-between space-x-3">
                            <div class="flex items-center justify-center md:w-[35%] w-[50%]">
                                <template v-if="!isImage">
                                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-52 sm:h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6 p-2">
                                            <InputImgSvg />
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" v-on:change="handleImage" />
                                        <InputError class="mt-2" :message="form.errors.image" />
                                    </label>
                                </template>
                                <template v-else>
                                    <img :src="imagePreview" v-if="imagePreview" class="rounded-md">
                                </template>
                            </div >
                            <div class="w-full">
                                <label for="default" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Types</label>
                                <select id="default" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="form.type">
                                    <option value="Movie">Movie</option>
                                    <option value="Tv">Tv</option>
                                </select>
                                <InputForm 
                                    title="Score"
                                    :required="true"
                                    type="text"
                                    v-model="form.score"
                                />
                            </div>
                           
                        </div>
                        
                        <InputError class="mt-2" :message="form.errors.score" />
                        <InputForm 
                            title="Status"
                            :required="true"
                            type="text"
                            v-model="form.status"
                        />
                        <InputError class="mt-2" :message="form.errors.status" />
                        <div class="w-full mb-4 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="px-4 py-2 bg-secondaryBtn rounded-t-lg dark:bg-gray-800">
                                <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-secondaryBtn border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a synopsis..." v-model="form.synopsis"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="text-white bg-primaryBtn hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                    </form>

                 </div>   
            </div>   
    </AppLayout>
</template>