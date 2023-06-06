<script setup>
import { useForm } from '@inertiajs/vue3';
import ButtonComponent from '../Components/ButtonComponent.vue';
import AppLayout from '../Layouts/AppLayout.vue'

const props = defineProps({
    data: Array,
})

const form = useForm({})

const reset = () => {
    if(confirm('reset?')){
        if (props.data.length === 0){
           alert('no report')
        } else {
            form.get(route('resetreport'))
        }
    }
}

function destroy(id) {
    if(confirm('are you sure?')){
        form.delete(route('reportdelete', id));
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-center w-full">
                <div class=" max-w-4xl w-full">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight selected">
                        report
                    </h2>
                </div>
            </div>
            <div class="max-w-4xl relative z-40">
                <button @click="handleFlash" class="absolute right-20" v-if="flash">
                    <div v-if="$page.props.flash.message" class="bg-secondaryBtn border-2 border-blue-300 rounded-md p-4 bg-opacity-90 text-gray-700 flex items-center space-x-4">
                        <WarningSvg />
                        <h1>{{ $page.props.flash.message }}</h1>
                    </div>
                </button>
            </div>
        </template>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-secondaryBtn overflow-hidden shadow-xl sm:rounded-lg md:p-10 p-2 ">
                    <ButtonComponent 
                        class="bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200"
                        children="reset"
                        type="button"
                        @click="reset()"
                        />
                    <template v-for="n in data" :key="n.id">
                        <div class="flex-1 flex bg-gray-400 p-2 rounded-md items-center justify-between pl-10">
                            <div class="flex space-x-10">
                                <div>
                                    <h1 class="text-lg font-medium">title</h1>
                                    <p class="text-md font-medium">{{ n.title }}</p>
                                </div>
                                <div>
                                    <h1 class="text-lg font-medium">content</h1>
                                    <p>{{ n.content }}</p>
                                </div>  
                            </div>  
                            <ButtonComponent 
                                class="bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200"
                                children="delete"
                                type="button"
                                @click="destroy(n.id)"
                                />
                        </div>
                    </template>
                </div>
            </div>
    </AppLayout>
</template>