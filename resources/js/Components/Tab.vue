<script setup>
defineProps({
    activeTab: String,
    tabs: Array,
    setActiveTab: Function
})
const styles = {
    tab: (name, activeTab) => {
      return  name === activeTab ? 'border-2 border-b-blue-400 hover:border-b-blue-400 font-medium rounded-sm text-sm px-2.5 py-1 mr-2 mb-2 focus:outline-none border-t-0 border-x-0' : 'border-2 hover:border-b-blue-400 font-medium rounded-sm text-sm px-2.5 py-1 mr-2 mb-2 focus:outline-none border-t-0 border-x-0'
    }
}
</script>

<template>
    <div class="flex space-x-1" >
        <div v-for="tab in tabs" >
            <button :class="styles.tab(tab, activeTab)" @click="setActiveTab(tab)">
                <h1 class="text-lg text-gray-500 font-medium">{{ tab }}</h1>
            </button>
        </div>
    </div>
</template>