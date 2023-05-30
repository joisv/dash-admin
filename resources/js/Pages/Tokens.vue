<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3';

import AppLayout from '../Layouts/AppLayout.vue';
import InputForm from '../Components/InputForm.vue';
import ButtonComponent from '../Components/ButtonComponent.vue';
import WarningSvg from '../Components/WarningSvg.vue'

const props = defineProps({
    name: {
        type: Array,
        default: () => ({})
    },
});
const form = useForm({
    token_name: ''
});

const submit = () => {
    form.post(route('gettoken'), {
        onSuccess: () => {
            form.reset()
        }
    })
}

</script>

<template>
    <AppLayout title="Add episodes">
        <template #header>
            <div class="w-full flex items-center justify-center">
                <div class="max-w-3xl h-full w-full">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight selected ">
                       Generate token
                    </h2>
                    <h1>{{ token }}</h1>
                </div>
            </div>
        </template>
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <form @submit.prevent="submit">
                       <div class="flex items-center w-full space-x-4">
                            <InputForm 
                                title="name"
                                :required="true"
                                type="text"
                                v-model="form.token_name"
                                class="w-[80%]"
                                
                            />
                            <InputError class="mt-2" :message="form.errors.token_name" />
                            <ButtonComponent 
                                class="bg-primaryBtn hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 h-fit mt-4"
                                children="Save"
                                type="submit"
                            />
                       </div>
                    </form>
                 </div>   
            </div>   
    </AppLayout>
</template>