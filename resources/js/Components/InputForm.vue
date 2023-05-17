<script setup>
import { ref, watchEffect } from 'vue'

const props = defineProps({
    title: String,
    required: Boolean,
    modelValue: String,
    type: String
})

defineEmits(['update:modelValue']);
const input = ref (null)

</script>

<template>
    <div class="mb-4">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ props.title }}</label>
        <input :type="props.type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
        autocomplete="off"
        ref="input"
        :required="props.required ? props.required : false"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        >
    </div>
</template>