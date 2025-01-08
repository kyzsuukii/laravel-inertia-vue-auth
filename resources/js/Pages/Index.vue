<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'

const logout = () => {
    router.post('/logout')
}

const user = usePage().props.auth.user

</script>

<template>
    <Head title="Home" />
    <div class="flex justify-center items-center min-h-screen">
        <div
            class="border border-black p-5 flex flex-col gap-2 w-80"
            v-if="user"
        >
            <div class="flex flex-col gap-1">
                <div class="flex">
                    <span class="font-semibold w-[90px]">Name</span>
                    <span class="w-[18px]">:</span>
                    <span>{{ user.name }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-[90px]">Email</span>
                    <span class="w-[15px]">:</span>
                    <span>{{ user.email }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-[90px]">Username</span>
                    <span class="w-[15px]">:</span>
                    <span>{{ user.username }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-[90px]">Created At</span>
                    <span class="w-[15px]">:</span>
                    <span>{{
                        new Date(user.created_at).toLocaleString()
                    }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-[90px]">Updated At</span>
                    <span class="w-[15px]">:</span>
                    <span>{{
                        new Date(user.updated_at).toLocaleString()
                    }}</span>
                </div>
            </div>
            <div class="text-center">
                <button
                    @click="logout"
                    type="button"
                    class="underline cursor-pointer bg-transparent p-0 border-0"
                >
                    Logout
                </button>
            </div>
        </div>
        <div v-else>
            <h1>You are not logged in</h1>
        </div>
    </div>
</template>
