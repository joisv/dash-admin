<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';

import AppLayout from '../Layouts/AppLayout.vue';
import InputForm from '../Components/InputForm.vue';
import ButtonComponent from '../Components/ButtonComponent.vue';

const props = defineProps({
    name: {
        type: Array,
        default: () => ({})
    },
   
});
const flash = ref(true)
const form = useForm({
    token_name: ''
});

console.log(props.name);

function handleFlash() {
    flash.value = false
}
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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                       Generate token
                    </h2>
                    <div class="max-w-7xl relative z-40">
                        <button @click="handleFlash" class="absolute right-20" v-if="flash">
                            <div v-if="$page.props.flash.message" class="bg-secondaryBtn border-2 border-blue-300 rounded-md p-4 bg-opacity-90 text-gray-700 flex items-center space-x-4">
                                <WarningSvg />
                                <h1>{{ $page.props.flash.message }}</h1>
                            </div>
                        </button>
                    </div>
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

                    <div class="flex items-center justify-between overflow-hidden sm:rounded-md p-3">
                        <h1>{{  }}</h1>
                        <ButtonComponent 
                                class="bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 h-fit mt-4"
                                children="delete"
                                type="submit"
                            />
                    </div>
                 </div>   
            </div>   
    </AppLayout>
</template>