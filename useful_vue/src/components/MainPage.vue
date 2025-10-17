<script setup>
import { onMounted, computed } from 'vue'
import { useDashboardStore } from '@/stores/dashbord'

const dashboardStore = useDashboardStore()

onMounted(async () => {
    await dashboardStore.loadModules()
})

const activeModules = computed(() =>
    dashboardStore.modules.filter(m => m.active)
)
</script>

<template>
    <aside class="w-64 bg-gray-800 text-white h-screen p-4">
        <h2 class="text-xl font-bold mb-6">Menu</h2>
        <ul class="space-y-2">
            <li v-for="module in activeModules" :key="module.id" class="p-2 hover:bg-white-700  text-white rounded">
                {{ module.name }}
            </li>
        </ul>
    </aside>
</template>