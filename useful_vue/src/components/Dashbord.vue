<script setup>
import { onMounted } from 'vue'
import { useDashboardStore } from '@/stores/dashbord'

const dashboardStore = useDashboardStore()

onMounted(async () => {
    await dashboardStore.loadModules()
})

</script>

<template>
    <div>
        <div v-for="module in dashboardStore.modules" :key="module.id" class="flex justify-between p-2">
            <span class="text-lg text-gray-800 font-medium">{{ module.name }}</span>
            <button @click="dashboardStore.toggleModule(module)" class="bg-cyan-500  cursor-pointer text-white rounded-md px-2 py-1">
                {{ module.active ? 'Désactiver' : 'Activer' }}
            </button>
        </div>

    </div>
</template>