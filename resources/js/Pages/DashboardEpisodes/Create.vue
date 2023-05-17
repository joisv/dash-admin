<script setup>
import { useForm } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';
import InputForm from '../../Components/InputForm.vue';
import ButtonComponent from '../../Components/ButtonComponent.vue';

const props = defineProps({
    series: {
        type: Array,
        default: () => ({})
    }
})
const form = useForm({
    title: '',
    series_id: ''
})

const submit = () => {
    form.post(route('episodes.store'))
}


</script>

<template>
    <AppLayout title="Add episodes">
        <template #header>
            <div class="w-full flex items-center justify-center">
                <div class="max-w-3xl h-full w-full">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                        Create new episodes 
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
                    <form @submit.prevent="submit">
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
                            class="bg-primaryBtn hover:bg-slate-800 focus:ring-4 focus:ring-slate-300"
                            children="Save"
                            type="submit"
                        />
                    </form>

                 </div>   
            </div>   
    </AppLayout>
</template>