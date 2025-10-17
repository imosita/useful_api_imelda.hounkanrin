import { useRouter } from 'vue-router'
import { defineStore } from 'pinia'
const baseUrl = 'http://127.0.0.1:8000/api'
const router = useRouter()

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('token') || null
    }),
    persist: true,
    actions: {
        async register(name, email, password) {
            const res = await fetch(`${baseUrl}/register`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, password })
            })
            const data = await res.json()
            if (res.ok) {
                this.token = data.token
                localStorage.setItem('token', data.token)
            }
        },
        async login(email, password,router) {
            const res = await fetch(`${baseUrl}/login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            })
            const data = await res.json()
            if (res.ok) {
                // const router = useRouter()
                this.token = data.token
                localStorage.setItem('token', data.token)
                router.push('/dashbord')   
            }
        }
    }
})  

