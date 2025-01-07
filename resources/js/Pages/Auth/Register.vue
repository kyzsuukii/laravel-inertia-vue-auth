<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: ''
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
        }
    })
}

function handleInput(field: string) {
    localStorage.setItem(`reg_${field}`, form[field])
}
</script>

<template>
    <Head title="Register" />
    <form @submit.prevent="handleSubmit">
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" v-model="form.name" @input="handleInput('name')" />
            <span v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</span>
        </div>
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" v-model="form.username" @input="handleInput('username')" />
            <span v-if="form.errors.username" class="text-red-500">{{ form.errors.username }}</span>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" v-model="form.email" @input="handleInput('email')" />
            <span v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</span>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" v-model="form.password" />
            <span v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</span>
        </div>
        <div>
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" id="password_confirmation" v-model="form.password_confirmation" />
            <span v-if="form.errors.password_confirmation" class="text-red-500">{{ form.errors.password_confirmation }}</span>
        </div>
        <button type="submit">Register</button>
    </form>
</template>
