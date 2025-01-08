<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import { useCaptchaStore } from '../../Stores/captcha'

const captcha = useCaptchaStore()

const form = useForm({
    login: '',
    password: '',
    captcha: '',
})

onMounted(() => {
    form.login = localStorage.getItem('login') || ''
    captcha.refresh()
})

function handleSubmit() {
    form.post('/login', {
        onSuccess: () => {
            localStorage.removeItem('login')
        },
        onError: () => {
            captcha.refresh()
        },
        preserveScroll: true
    })
}

function handleInput() {
    localStorage.setItem('login', form.login)
}
</script>

<template>

    <Head title="Login" />
    <div class="border p-5 w-[400px]">
        <div class="text-center text-2xl font-semibold">Login</div>
        <div class="text-center">Login Form</div>
        <form @submit.prevent="handleSubmit">
            <div class="mb-3">
                <div class="font-semibold">Login:</div>
                <input type="text" id="login" v-model="form.login" @input="handleInput"
                    class="w-full border focus:ring-0 focus:outline-none" />
                <div v-if="form.errors.login" class="mt-1 text-red-500">
                    {{ form.errors.login }}
                </div>
            </div>
            <div class="mb-3">
                <div class="font-semibold">Password:</div>
                <input type="password" id="password" v-model="form.password"
                    class="w-full border focus:ring-0 focus:outline-none" />
                <div v-if="form.errors.password" class="mt-1 text-red-500">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="mb-3">
                <div class="font-semibold">Captcha:</div>
                <div class="flex items-center gap-2 mb-2">
                    <img :src="captcha.image" alt="CAPTCHA" class="border" />
                    <button type="button" @click="captcha.refresh"
                        class="underline cursor-pointer bg-transparent p-0 border-0" :disabled="captcha.isLoading">
                        Refresh
                    </button>
                </div>
                <input type="text" id="captcha" v-model="form.captcha"
                    class="w-full border focus:ring-0 focus:outline-none" placeholder="Enter the code shown above" />
                <div v-if="form.errors.captcha" class="mt-1 text-red-500">
                    {{ form.errors.captcha }}
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="underline cursor-pointer bg-transparent p-0 border-0">
                    Login
                </button>
            </div>
        </form>
        <div class="text-center mt-3">
            <Link href="/register" class="underline cursor-pointer bg-transparent p-0 border-0">Create an account</Link>
        </div>
    </div>
</template>
