// stores/dashboard.js
import { defineStore } from 'pinia'

export const useDashboardStore = defineStore('dashboard', {
    state: () => ({
        modules: []
    }),
    actions: {
        async loadModules() {
            try {
                const token = localStorage.getItem('token')
                const res = await fetch('http://127.0.0.1:8000/api/modules', {
                    headers: { 'Authorization': `Bearer ${token}` }
                })
                if (res.ok) this.modules = await res.json()
            } catch (error) {
                console.error('Failed to load modules', error)
            }
        },
        async toggleModule(module) {
            const token = localStorage.getItem('token')
            const action = module.active ? 'deactivate' : 'activate'
            const res = await fetch(`http://127.0.0.1:8000/api/modules/${module.id}/${action}`, {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}` }
            })
            if (res.ok) module.active = !module.active
        }
    }
})   