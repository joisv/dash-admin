<script setup>
import { ref } from 'vue';

defineProps({
    modelValue: String,
    values: Array,
    title: String,
    ids: String
})
defineEmits(['update:modelValue']);
const input = ref (null)

</script>

<template>
    <label :for="ids" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ title }}</label>
    <select :id="ids" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
    ref="input"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    >
        <template v-for="value in values">
            <option :value="value">{{ value }}</option>
        </template>
    </select>
</template>