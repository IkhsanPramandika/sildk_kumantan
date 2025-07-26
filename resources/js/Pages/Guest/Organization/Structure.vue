<template>
    <GuestLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-lg p-8 mb-8 text-white">
                <div class="max-w-3xl">
                    <h1 class="text-4xl font-bold mb-4">Struktur Organisasi</h1>
                    <p class="text-xl text-red-100">
                        Struktur organisasi pemerintahan desa yang mengelola dan melayani masyarakat
                    </p>
                </div>
            </div>

            <!-- Error State -->
            <div v-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <ExclamationTriangleIcon class="w-5 h-5 text-red-600 mr-2" />
                    <p class="text-red-800">{{ error }}</p>
                </div>
            </div>

            <!-- Organization Structure -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <div v-if="organization" class="space-y-8">
                    <!-- Organization Info -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ organization.title }}</h2>
                        <div class="prose max-w-none" v-html="organization.description"></div>
                    </div>

                    <!-- Structure Image -->
                    <div v-if="organization.structure_image" class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Struktur Organisasi</h3>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <LazyImage :src="`/storage/${organization.structure_image}`" :alt="organization.title" class="w-full h-auto rounded-lg" />
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-12">
                    <DocumentTextIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Struktur Belum Tersedia</h3>
                    <p class="text-gray-600">
                        Informasi struktur organisasi sedang dalam proses penyusunan dan akan segera dipublikasikan.
                    </p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ExclamationTriangleIcon, DocumentTextIcon } from '@heroicons/vue/24/outline'
import LazyImage from '@/Components/LazyImage.vue'

const props = defineProps({
    organization: {
        type: Object,
        default: null
    },
    error: {
        type: String,
        default: null
    }
})
</script>
