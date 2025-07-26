<template>
    <Head title="Lupa Password" />
  
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div>
          <div class="flex items-center justify-center mb-6">
            <LazyImage 
                src="/placeholder.svg?height=48&width=48" 
                alt="Logo Desa" 
                imageClass="h-12 w-12"
            />
          </div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Lupa Password
          </h2>
          <p class="mt-2 text-center text-sm text-gray-600">
            Masukkan email Anda untuk mendapatkan link reset password
          </p>
        </div>
  
        <!-- Success Message -->
        <div v-if="status" class="rounded-md bg-green-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-green-800">
                {{ status }}
              </p>
            </div>
          </div>
        </div>
  
        <!-- Form -->
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email
            </label>
            <div class="mt-1">
              <input
                id="email"
                v-model="form.email"
                name="email"
                type="email"
                autocomplete="email"
                required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                :class="{ 'border-red-300': form.errors.email }"
                placeholder="Masukkan alamat email Anda"
              />
              <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                {{ form.errors.email }}
              </div>
            </div>
          </div>
  
          <div>
            <button
              type="submit"
              :disabled="form.processing"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <EnvelopeIcon class="h-5 w-5 text-blue-500 group-hover:text-blue-400" aria-hidden="true" />
              </span>
              <span v-if="form.processing">Mengirim...</span>
              <span v-else>Kirim Link Reset</span>
            </button>
          </div>
  
          <!-- Back to Login -->
          <div class="text-center">
            <Link :href="route('login')" class="font-medium text-blue-600 hover:text-blue-500">
              ← Kembali ke Login
            </Link>
          </div>
        </form>
  
        <!-- Footer Info -->
        <div class="text-center text-xs text-gray-500">
          <p>Sistem Informasi Desa Digital</p>
          <p class="mt-1">&copy; {{ new Date().getFullYear() }} All rights reserved</p>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Head, Link, useForm, router } from '@inertiajs/vue3'
  import { 
    EnvelopeIcon,
    CheckCircleIcon 
  } from '@heroicons/vue/24/outline'
  import { ref } from 'vue'
  import LazyImage from '@/Components/LazyImage.vue'
  
  defineProps({
    status: String,
  })
  
  const form = useForm({
    email: '',
  })
  
  const submit = () => {
    form.post(route('password.email'))
  }
  </script>
