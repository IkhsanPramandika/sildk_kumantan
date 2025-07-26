<template>
    <GuestLayout>
        <Head title="Detail Pengaduan" />

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">Detail Pengaduan</h1>
                    <p class="text-xl text-red-100">
                        Informasi lengkap tentang pengaduan Anda
                    </p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ complaint.title }}
                            </h2>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                :class="getStatusClass(complaint.status)">
                                {{ getStatusText(complaint.status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-6">
                        <!-- Complaint Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Nomor Pengaduan</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ complaint.complaint_number }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Kategori</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ getCategoryText(complaint.category) }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Tanggal Dibuat</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ formatDate(complaint.created_at) }}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Pelapor</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ complaint.resident?.full_name }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">NIK</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ complaint.resident?.nik }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Alamat</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ complaint.resident?.address }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Deskripsi Pengaduan</h3>
                            <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">
                                {{ complaint.description }}
                            </div>
                        </div>

                        <!-- Response -->
                        <div v-if="complaint.response">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggapan</h3>
                            <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">
                                {{ complaint.response }}
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Ditanggapi pada {{ formatDate(complaint.response_date) }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <Link :href="route('complaints.check')"
                                class="text-sm text-gray-600 hover:text-gray-900">
                                Kembali ke Cek Status
                            </Link>
                            <Link :href="route('home')"
                                class="text-sm text-gray-600 hover:text-gray-900">
                                Kembali ke Beranda
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const props = defineProps({
    complaint: {
        type: Object,
        required: true
    }
})

const getStatusClass = (status) => {
    const classes = {
        received: 'bg-blue-100 text-blue-800',
        in_progress: 'bg-yellow-100 text-yellow-800',
        completed: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
    const texts = {
        received: 'Diterima',
        in_progress: 'Diproses',
        completed: 'Selesai',
        rejected: 'Ditolak'
    }
    return texts[status] || status
}

const getCategoryText = (category) => {
    const texts = {
        infrastructure: 'Infrastruktur',
        service: 'Pelayanan',
        social: 'Sosial',
        economy: 'Ekonomi',
        other: 'Lainnya'
    }
    return texts[category] || category
}

const formatDate = (date) => {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script> 