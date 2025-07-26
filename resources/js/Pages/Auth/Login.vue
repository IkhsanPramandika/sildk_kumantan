<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div>
                <div class="flex items-center justify-center mb-6">
                    <img src="images/logo-desa.png" alt="Logo Desa" height="100" width="100">
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Masuk ke Akun Anda
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Silakan masuk untuk mengakses panel admin
                </p>
            </div>

            <!-- Login Form -->
            <form class="mt-8 space-y-6" @submit.prevent="submit">
                <div class="rounded-md shadow-sm -space-y-px">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" v-model="form.email" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            :class="{ 'border-red-300': form.errors.email }" placeholder="Alamat Email" />
                        <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <div class="relative">
                            <input id="password" v-model="form.password" name="password"
                                :type="showPassword ? 'text' : 'password'" autocomplete="current-password" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                :class="{ 'border-red-300': form.errors.password }" placeholder="Password" />
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                @click="showPassword = !showPassword">
                                <EyeIcon v-if="!showPassword" class="h-5 w-5 text-gray-400 hover:text-gray-500" />
                                <EyeSlashIcon v-else class="h-5 w-5 text-gray-400 hover:text-gray-500" />
                            </button>
                        </div>
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" :disabled="form.processing"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <LockClosedIcon class="h-5 w-5 text-blue-500 group-hover:text-blue-400"
                                aria-hidden="true" />
                        </span>
                        <span v-if="form.processing">Memproses...</span>
                        <span v-else>Masuk</span>
                    </button>
                </div>

                <!-- Error Message -->
                <div v-if="form.errors.email" class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Login Gagal
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p v-if="form.errors.email">{{ form.errors.email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="rounded-md bg-blue-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <LockClosedIcon class="h-5 w-5 text-blue-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Keamanan Login
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Maksimal 5 percobaan login per menit</li>
                                    <li>Akun akan terkunci sementara jika terlalu banyak percobaan gagal</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Back to Home -->
            <div class="text-center">
                <Link :href="route('home')" class="font-medium text-blue-600 hover:text-blue-500">
                ← Kembali ke Beranda
                </Link>
            </div>

            <!-- Footer Info -->
            <div class="text-center text-xs text-gray-500">
                <p>Sistem Informasi Desa Digital</p>
                <p class="mt-1">&copy; {{ new Date().getFullYear() }} All rights reserved</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    LockClosedIcon,
    EyeIcon,
    EyeSlashIcon,
    XCircleIcon,
} from '@heroicons/vue/24/outline'
import LazyImage from '@/Components/LazyImage.vue'

// Form handling
const form = useForm({
    email: '',
    password: '',
})

const showPassword = ref(false)

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password')
        },
    })
}
</script>
