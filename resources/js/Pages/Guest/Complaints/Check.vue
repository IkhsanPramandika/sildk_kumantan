<template>
    <GuestLayout>
        <Head title="Cek Status Pengaduan" />

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">Cek Status Pengaduan</h1>
                    <p class="text-xl text-red-100">
                        Masukkan nomor pengaduan dan NIK untuk melihat status pengaduan Anda
                        </p>
                    </div>
            </div>
                    </div>
                    
        <!-- Content Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <form @submit.prevent="checkStatus" class="space-y-6">
                            <!-- Complaint Number -->
                    <div>
                                <label for="complaint_number" class="block text-sm font-medium text-gray-700">
                                    Nomor Pengaduan
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="complaint_number" v-model="form.complaint_number"
                                        class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Masukkan nomor pengaduan" required />
                                </div>
                                <p v-if="form.errors.complaint_number" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.complaint_number }}
                                </p>
                    </div>
                    
                            <!-- NIK -->
                    <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">
                                    NIK
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="nik" v-model="form.nik"
                                        class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Masukkan NIK" required maxlength="16" />
                                </div>
                                <p v-if="form.errors.nik" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.nik }}
                                </p>
                    </div>
                    
                            <!-- Submit Button -->
                    <div>
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    :disabled="form.processing">
                                    {{ form.processing ? 'Memeriksa...' : 'Cek Status' }}
                                </button>
                    </div>
                        </form>

                        <!-- Error Message -->
                        <div v-if="error" class="mt-6 p-4 bg-red-50 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        {{ error }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ref } from 'vue'

const error = ref('')

const form = useForm({
    complaint_number: '',
    nik: ''
})

const checkStatus = () => {
    error.value = ''
    form.post(route('complaints.check'), {
        onError: (errors) => {
            if (errors.complaint_number || errors.nik) {
                error.value = 'Nomor pengaduan atau NIK tidak valid'
            }
        }
    })
}
</script>
