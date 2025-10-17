<template>
    <!-- <form @submit.prevent="submit" class="space-y-4">
    <input v-model="name" type="text" placeholder="Nom" class="w-full p-2 border" required />
    <input v-model="email" type="email" placeholder="Email" class="w-full p-2 border" required />
    <input v-model="password" type="password" placeholder="Mot de passe" class="w-full p-2 border" required />
    <button type="submit" class="bg-green-500 text-white px-4 py-2">Register</button>
    </form> -->

    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-sky-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">

                <div class="max-w-md mx-auto">
                    <div>
                        <h1 class="text-2xl font-semibold">Login</h1>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <form @submit.prevent="submit" class="space-y-4">

                                <div class="relative">
                                    <input v-model="name" type="text" placeholder="Nom"
                                        class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600"
                                        required />
                                    <label for="name"
                                        class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">
                                        Name</label>
                                </div>

                                <div class="relative">
                                    <input v-model="email" type="email" placeholder="Email"
                                        class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600"
                                        required />
                                    <label for="email"
                                        class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Email</label>
                                </div>

                                <div class="relative">
                                    <input v-model="password" type="password" placeholder="Mot de passe"
                                        class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600"
                                        required />
                                    <label for="password"
                                        class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                                </div>
                                <div class="relative">
                                    <!-- <button class="bg-cyan-500 text-white rounded-md px-2 py-1">Submit</button> -->
                                    <button type="submit" :disabled="loading"
                                        class="bg-cyan-500 text-white cursor-pointer  rounded-md px-2 py-1">
                                        {{ loading ? 'Chargement...' : 'Register' }}
                                    </button>
                                    <div v-if="success" class="text-green-500"> Account created successfully!
                                    </div>
                                    <div class="flex ">
                                        <span>Already have an account?</span>
                                        
                                        <RouterLink to="/auth/login" class="no-underline hover:underline text-blue-400">
                                            login
                                        </RouterLink>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { RouterLink } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const loading = ref(false)
const success = ref(false)
const authStore = useAuthStore()

// const submit = () => authStore.register(name.value, email.value, password.value)

const submit = async () => {
    loading.value = true
    success.value = false
    await authStore.register(name.value, email.value, password.value)
    loading.value = false
    success.value = true
    // setTimeout(() => success.value = false, 10000)
}
</script>