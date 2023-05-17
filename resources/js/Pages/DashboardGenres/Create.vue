<script setup>
import { useForm } from '@inertiajs/vue3';

import AppLayout from '../../Layouts/AppLayout.vue';
import InputForm from '../../Components/InputForm.vue';
import ButtonComponent from '../../Components/ButtonComponent.vue';
import InputError from '../../Components/InputError.vue'

const form = useForm({
    names: '',
})


const submit = () => {
    form.post(route('genres.store'))
}


</script>

<template>
    <AppLayout title="Add episodes">
        <template #header>
            <div class="w-full flex items-center justify-center">
                <div class="max-w-3xl h-full w-full">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                        Create new genre 
                    </h2>
                </div>
            </div>
        </template>
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h1 class="text-lg font-medium text-gray-400" v-if="!form.names">e.g Comdey</h1>
                            <h1 class="text-lg font-medium text-primaryBtn" v-if="form.names">{{ form.names }}</h1>
                        </div>
                    </div>
                    <form @submit.prevent="submit">
                        <InputForm 
                            title="Title"
                            :required="true"
                            type="text"
                            v-model="form.names"
                            
                        />
                        <InputError class="mt-2" :message="form.errors.names" />
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