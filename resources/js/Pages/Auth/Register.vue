<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
})

onMounted(() => {
    form.name = localStorage.getItem('reg_name') || ''
    form.username = localStorage.getItem('reg_username') || ''
    form.email = localStorage.getItem('reg_email') || ''
})

function handleSubmit() {
    form.post('/register', {
        onSuccess: () => {
            localStorage.removeItem('reg_name')
            localStorage.removeItem('reg_username')
            localStorage.removeItem('reg_email')
        },
    })
}

function handleInput(field: string) {
    localStorage.setItem(`reg_${field}`, form[field])
}
</script>

<template>
    <Head title="Register" />
    <div class="flex justify-center items-center min-h-screen">
        <div class="border p-5 w-[400px]">
            <div class="text-center text-2xl font-semibold">Register</div>
            <div class="text-center">Register Form</div>
            <form @submit.prevent="handleSubmit">
                <div class="mb-3">
                    <div class="font-semibold">Name:</div>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        @input="handleInput('name')"
                        class="w-full border focus:ring-0 focus:outline-none"
                    />
                    <div v-if="form.errors.name" class="mt-1">
                        {{ form.errors.name }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="font-semibold">Username:</div>
                    <input
                        type="text"
                        id="username"
                        v-model="form.username"
                        @input="handleInput('username')"
                        class="w-full border focus:ring-0 focus:outline-none"
                    />
                    <div v-if="form.errors.username" class="mt-1">
                        {{ form.errors.username }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="font-semibold">Email:</div>
                    <input
                        type="email"
                        id="email"
                        v-model="form.email"
                        @input="handleInput('email')"
                        class="w-full border focus:ring-0 focus:outline-none"
                    />
                    <div v-if="form.errors.email" class="mt-1">
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="font-semibold">Password:</div>
                    <input
                        type="password"
                        id="password"
                        v-model="form.password"
                        class="w-full border focus:ring-0 focus:outline-none"
                    />
                    <div v-if="form.errors.password" class="mt-1">
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="font-semibold">Password Confirmation:</div>
                    <input
                        type="password"
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        class="w-full border focus:ring-0 focus:outline-none"
                    />
                    <div v-if="form.errors.password_confirmation" class="mt-1">
                        {{ form.errors.password_confirmation }}
                    </div>
                </div>
                <div class="text-center">
                    <button
                        type="submit"
                        class="underline cursor-pointer bg-transparent p-0 border-0"
                    >
                        Register
                    </button>
                </div>
            </form>
            <div class="text-center mt-3">
                <Link
                    href="/login"
                    class="underline cursor-pointer bg-transparent p-0 border-0"
                    >Already have an account?</Link
                >
            </div>
        </div>
    </div>
</template>
