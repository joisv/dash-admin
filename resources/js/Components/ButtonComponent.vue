<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    class: String,
    children: String,
    type: String
})
const variant = ref(false)
const common = 'bg-primaryBtn text-backGround'

onMounted(() => {
    if(common){
        variant.value = true
    } else {
        variant.value = false
    }
})
</script>

<template>
    <button :type="props.type">
        <div class="px-2 py-1 rounded-sm" :class="variant ? props.class : common">
            <h1>{{ children }}</h1>
        </div>
    </button>
</template>