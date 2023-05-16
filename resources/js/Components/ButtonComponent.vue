<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    class: String,
    children: String,
    type: String
})
const variant = ref(false)
const common = 'bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300'

onMounted(() => {
    if(common){
        variant.value = true
    } else {
        variant.value = false
    }
})
</script>

<template>
    <button :type="type" class="focus:outline-none text-white font-medium rounded-lg text-sm px-3 py-1.5 mb-2" :class="props.class? props.class: common">
            <h1>{{ children }}</h1>
    </button>
</template>