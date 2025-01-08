<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import { useCaptchaStore } from '../../Stores/captcha'

const captcha = useCaptchaStore()

const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    captcha: '',
})

onMounted(() => {
    form.name = localStorage.getItem('reg_name') || ''
    form.username = localStorage.getItem('reg_username') || ''
    form.email = localStorage.getItem('reg_email') || ''
    captcha.refresh()
})

function handleSubmit() {
    form.post('/register', {
        onSuccess: () => {
            localStorage.removeItem('reg_name')
            localStorage.removeItem('reg_username')
            localStorage.removeItem('reg_email')
        },
        onError: () => {
            captcha.refresh()
        },
        preserveScroll: true
    })
}

function handleInput(field: string) {
    localStorage.setItem(`reg_${field}`, form[field])
}
</script>

<template>

    <Head title="Register" />
    <div class="border p-5 w-[600px]">
        <div class="text-center text-2xl font-semibold">Register</div>
        <div class="text-center">Register Form</div>
        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-3">
                    <div class="font-semibold">Name:</div>
                    <input type="text" id="name" v-model="form.name" @input="handleInput('name')"
                        class="w-full border focus:ring-0 focus:outline-none" />
                    <div v-if="form.errors.name" class="mt-1 text-red-500">
                        {{ form.errors.name }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="font-semibold">Username:</div>
                    <input type="text" id="username" v-model="form.username" @input="handleInput('username')"
                        class="w-full border focus:ring-0 focus:outline-none" />
                    <div v-if="form.errors.username" class="mt-1 text-red-500">
                        {{ form.errors.username }}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="font-semibold">Email:</div>
                <input type="email" id="email" v-model="form.email" @input="handleInput('email')"
                    class="w-full border focus:ring-0 focus:outline-none" />
                <div v-if="form.errors.email" class="mt-1 text-red-500">
                    {{ form.errors.email }}
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-3">
                    <div class="font-semibold">Password:</div>
                    <input type="password" id="password" v-model="form.password"
                        class="w-full border focus:ring-0 focus:outline-none" />
                    <div v-if="form.errors.password" class="mt-1 text-red-500">
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="font-semibold">Password Confirmation:</div>
                    <input type="password" id="password_confirmation" v-model="form.password_confirmation"
                        class="w-full border focus:ring-0 focus:outline-none" />
                    <div v-if="form.errors.password_confirmation" class="mt-1 text-red-500">
                        {{ form.errors.password_confirmation }}
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 items-end mb-3">
                <div>
                    <div class="font-semibold mb-2">Captcha:</div>
                    <div class="flex items-center gap-2">
                        <img :src="captcha.image" alt="CAPTCHA" class="border" />
                        <button type="button" @click="captcha.refresh"
                            class="underline cursor-pointer bg-transparent p-0 border-0" :disabled="captcha.isLoading">
                            Refresh
                        </button>
                    </div>
                </div>
                <div>
                    <input type="text" id="captcha" v-model="form.captcha"
                        class="w-full border focus:ring-0 focus:outline-none" placeholder="Enter the code shown above" />
                    <div v-if="form.errors.captcha" class="mt-1 text-red-500">
                        {{ form.errors.captcha }}
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="underline cursor-pointer bg-transparent p-0 border-0">
                    Register
                </button>
            </div>
        </form>
        <div class="text-center mt-3">
            <Link href="/login" class="underline cursor-pointer bg-transparent p-0 border-0">Already have an account?
            </Link>
        </div>
    </div>
</template>
