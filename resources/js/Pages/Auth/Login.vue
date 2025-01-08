<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const form = useForm({
    login: '',
    password: ''
})

onMounted(() => {
    form.login = localStorage.getItem('login') || ''
})

function handleSubmit() {
    form.post('/login', {
        onSuccess: () => {
            localStorage.removeItem('login')
        }
    })
}

function handleInput() {
    localStorage.setItem('login', form.login)
}
</script>

<template>
    <Head title="Login" />
    <div class="flex justify-center items-center min-h-screen">
        <div class="border p-5 w-[400px]">
            <div class="text-center text-2xl font-semibold">Login</div>
            <div class="text-center">Login Form</div>
            <form @submit.prevent="handleSubmit">
                <div class="mb-3">
                    <div class="font-semibold">Login:</div>
                    <input 
                        type="text" 
                        id="login" 
                        v-model="form.login" 
                        @input="handleInput"
                        class="w-full border focus:ring-0 focus:outline-none"
                    />
                    <div v-if="form.errors.login" class="mt-1">{{ form.errors.login }}</div>
                </div>
                <div class="mb-3">
                    <div class="font-semibold">Password:</div>
                    <input 
                        type="password" 
                        id="password" 
                        v-model="form.password"
                        class="w-full border focus:ring-0 focus:outline-none"
                    />
                    <div v-if="form.errors.password" class="mt-1">{{ form.errors.password }}</div>
                </div>
                <div class="text-center">
                    <button type="submit" class="underline cursor-pointer bg-transparent p-0 border-0">Login</button>
                </div>
            </form>
            <div class="text-center">
                <Link href="/register" class="underline cursor-pointer bg-transparent p-0 border-0">Create an account</Link>
            </div>
        </div>
    </div>
</template>
