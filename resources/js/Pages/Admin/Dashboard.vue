<template>
    <AdminLayout title="Dashboard">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <UsersIcon class="w-8 h-8 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Penduduk</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.residents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <ShoppingBagIcon class="w-8 h-8 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Produk UMKM</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.products }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <CalendarIcon class="w-8 h-8 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Event Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.activeEvents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100">
                        <ExclamationTriangleIcon class="w-8 h-8 text-red-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pengaduan Baru</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.newComplaints }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Events -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Event Terbaru</h3>
                </div>
                <div class="p-6">
                    <div v-if="recentEvents.length === 0" class="text-gray-500 text-center py-4">
                        Tidak ada event terbaru
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="event in recentEvents" :key="event.id" class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <CalendarIcon class="w-8 h-8 text-blue-600" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ event.title }}</p>
                                <p class="text-sm text-gray-500">{{ formatDate(event.start_date) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Complaints -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pengaduan Terbaru</h3>
                </div>
                <div class="p-6">
                    <div v-if="recentComplaints.length === 0" class="text-gray-500 text-center py-4">
                        Tidak ada pengaduan terbaru
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="complaint in recentComplaints" :key="complaint.id"
                            class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <ExclamationTriangleIcon class="w-8 h-8 text-red-600" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ complaint.title }}</p>
                                <p class="text-sm text-gray-500">{{ complaint.resident?.full_name }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusClass(complaint.status)">
                                    {{ getStatusText(complaint.status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
    UsersIcon,
    ShoppingBagIcon,
    CalendarIcon,
    ExclamationTriangleIcon
} from '@heroicons/vue/24/outline'

defineProps({
    stats: Object,
    recentEvents: Array,
    recentNews: Array,
    recentComplaints: Array
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        received: 'bg-blue-100 text-blue-800',
        in_progress: 'bg-orange-100 text-orange-800',
        completed: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
    const texts = {
        pending: 'Menunggu',
        received: 'Diterima',
        in_progress: 'Diproses',
        completed: 'Selesai',
        rejected: 'Ditolak'
    }
    return texts[status] || status
}
</script>
