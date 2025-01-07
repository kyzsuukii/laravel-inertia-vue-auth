<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'

const logout = () => {
    router.post('/logout')
}
</script>

<template>
    <Head title="Home" />
    <div>
        <h1>Welcome to your Inertia app!</h1>
        <button @click="logout" type="button">Logout</button>
    </div>
</template>
