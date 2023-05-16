<script setup>
const props = defineProps({
    headers:{
        type: Array,
        default: () => ({})
    },
})


</script>

<template>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-secondaryBtn dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <template v-for="header in headers">
                        <th scope="col" class="px-6 py-3">
                            {{ header }}
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <slot>

                </slot>
            </tbody>
        </table>
    </div>
</template>