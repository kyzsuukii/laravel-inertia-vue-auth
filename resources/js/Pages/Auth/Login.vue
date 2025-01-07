<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
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
    <form @submit.prevent="handleSubmit">
        <div>
            <label for="login">Login</label>
            <input type="text" id="login" v-model="form.login" @input="handleInput" />
            <span v-if="form.errors.login" class="text-red-500">{{ form.errors.login }}</span>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" v-model="form.password" />
            <span v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</span>
        </div>
        <button type="submit">Login</button>
    </form>
</template>
