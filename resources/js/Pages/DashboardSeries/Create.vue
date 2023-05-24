<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watchEffect } from 'vue'

import AppLayout from '@/Layouts/AppLayout.vue';
import InputForm from '@/Components/InputForm.vue';
import InputError from '@/Components/InputError.vue';
import InputImgSvg from '@/Components/InputImgSvg.vue'
import SelectInput from '@/Components/SelectInput.vue';
import ButtonComponent from '@/Components/ButtonComponent.vue';

const props = defineProps({
    genres: {
        type: Object,
        default: () => ({})
    }
})
const imagePreview = ref(null)
const isResolutions = ref(false)
const result = ref({})
const isGenerate = ref(false)
const isError = ref(false)
const isDownload = ref(false)
const options = ['Movie', 'Tv']
const status = ['ongoing', 'complete', 'pending']
const season = ['Winter', 'Summer', 'Fall', 'Spring']
const form = useForm({
    title: '',
    original_title: '',
    type: '',
    score: '',
    genres: [],
    image: null,
    status: '',
    season: '',
    year: '',
    synopsis: '',
    resolutions: [],
});

watchEffect(() => {
    form.type === 'Movie' ? isResolutions.value = true : form.type === 'Tv' ? isResolutions.value = false : false
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

const handleImage = (event) => {
    form.image = event.target.files[0];
    console.log(form.image);
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

const handleGenerate = async (id) => {
    isGenerate.value = true
    try {
        const response = await axios.get(`/anime/full/${id}`);
        result.value = response.data.data;
        form.title = result.value.title
        form.original_title = result.value.title_japanese
        form.image = result.value.images.jpg.large_image_url
        imagePreview.value = result.value.images.jpg.large_image_url
        form.score = result.value.score
        form.season = result.value.season
        form.year = result.value.year
        form.synopsis = result.value.synopsis
        isGenerate.value = false
        isError.value = false
        console.log(result.value.synopsis);
    } catch (error) {
        isGenerate.value = false
        isError.value = true
    }
};
</script>

<template>
    <AppLayout title="Add series">
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
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2" :class="isGenerate ? 'bg-opacity-50' : null ">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex space-x-3 items-center">
                            <img class="rounded-full  h-14 w-14 sm:h-16 sm:w-16" src="https://flowbite.com/docs/images/examples/image-4@2x.jpg" v-if="!imagePreview">
                            <img :src="imagePreview" v-if="imagePreview" class="rounded-full h-16 w-16 sm:h-16 sm:w-16 object-cover object-top">
                            <div>
                                <h1 class="text-lg font-medium text-primaryBtn" v-if="!form.title">Youre title here...</h1>
                                <h1 class="text-lg font-medium text-primaryBtn" v-if="form.title">{{ form.title }}</h1>
                            </div>
                        </div>
                        <div>
                            <div class="bg-red-300 p-2 rounded-sm text-medium" v-if="isError">
                                <h1>something went wrong</h1>
                            </div>
                        <InputForm 
                            :required="false"
                            type="text"
                            v-model="generate"
                            
                        />
                        <ButtonComponent 
                            class="bg-primaryBtn hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 h-fit"
                            children="generate"
                            type="submit"
                            @click="handleGenerate(generate)"
                        />
                </div>
                    </div>
                    <form @submit.prevent="submit">
                        <InputForm 
                            title="Title"
                            :required="false"
                            type="text"
                            v-model="form.title"
                            
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                        <InputForm 
                            title="Original_title"
                            :required="false"
                            type="text"
                            v-model="form.original_title"
                        />
                        <InputError class="mt-2" :message="form.errors.original_title" />
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
                                <InputError class="mt-2" :message="form.errors.type" />
                                <div class="flex justify-between space-x-2">
                                    <InputForm 
                                        title="Score"
                                        :required="false"
                                        type="text"
                                        v-model="form.score"
                                    />
                                    <InputError class="mt-2" :message="form.errors.score" />
                                    <InputForm 
                                        title="Year"
                                        :required="false"
                                        type="text"
                                        v-model="form.year"
                                    />
                                    <InputError class="mt-2" :message="form.errors.year" />
                                   <div>
                                        <SelectInput 
                                            v-model="form.season"
                                            :values="season"
                                            title="Season"
                                            ids="season"
                                        />
                                        <InputError class="mt-2" :message="form.errors.season" />
                                   </div>
                                </div>
                            </div>
                           
                        </div>
                        
                        <SelectInput 
                            v-model="form.status"
                            title="Status"
                            :values="status"
                            ids="status"
                        />
                        <InputError class="mt-2" :message="form.errors.status" />
                        <div v-if="isResolutions">
                           <div class="flex space-x-2">
                                <ButtonComponent 
                                    class="bg-accent hover:bg-red-500 focus:ring-4 focus:ring-orange-200"
                                    children="add resolution"
                                    type="button"
                                    @click="addResolutions"
                                    />
                                <p class="text-red-400 text-sm font-medium">*required</p>
                           </div>
                            <template v-for="(resolution, index) in form.resolutions">
                                <div class="flex justify-between items-center space-x-3 w-full">
                                    <ButtonComponent 
                                        class="bg-red-400 hover:bg-red-500 focus:ring-4 focus:ring-red-300 h-fit"
                                        children="del"
                                        type="button"
                                        @click="removeResolutons(index)"
                                        />
                                    <div class="mb-6">
                                        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Resolutions</label>
                                        <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="720p"
                                            v-model="resolution.resolution"
                                            :aria-label="`resolution ${index +1 } resolution`"
                                        >
                                    </div>
                                    <div class="mb-6 w-[75%]">
                                        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">stream url</label>
                                        <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="required"
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
                                </div>
                            </template>
                            
                        </div>
                        <!-- download -->
                       
                        <div class="w-full h-28 overflow-auto mb-4 border-2 border-gray-200 rounded-md p-2 flex flex-wrap space-x-2">
                            <template v-for="( genre, index ) in props.genres" :key="genre.id">
                                <div class="p-1 w-fit h-fit border-2 border-gray-400 rounded-md " :class="{'border-2 border-red-400' : form.errors.genres}">
                                     <input type="checkbox" :name="`genres${index+1}`" :id="`genres${index+1}`" class="opacity-50 absolute" :value="genre.id" v-model="form.genres" >
                                     <label :for="`genres${index+1}`" class="px-2 py-1 font-medium text-primaryBtn">{{ genre.names }}</label>
                                </div>
                            </template>
                        </div>
                        <div class="w-full mb-4 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="px-4 py-2 bg-secondaryBtn rounded-t-lg dark:bg-gray-800">
                                <textarea id="synopsis" rows="4" class="w-full px-0 text-sm text-gray-900 bg-secondaryBtn border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a synopsis..." v-model="form.synopsis"></textarea>
                                <InputError class="mt-2" :message="form.errors.synopsis" />
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