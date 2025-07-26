<template>
    <AdminLayout title="Detail Agenda">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Detail Kegiatan</h3>
                <div class="flex space-x-2">
                    <Link :href="route('admin.events.edit', event.id)"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 flex items-center">
                        <PencilIcon class="w-5 h-5 mr-2" />
                        Edit
                    </Link>
                    <Link :href="route('admin.events.index')"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Kembali
                    </Link>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Judul Event</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ event.title || '-' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Kategori</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ getCategoryText(event.category) }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Status</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="getStatusClass(event.status)">
                                {{ getStatusText(event.status) }}
                            </span>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Tanggal Mulai</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ formatDate(event.start_date) }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Tanggal Selesai</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ formatDate(event.end_date) }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Lokasi</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ event.location || '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Gambar Utama Event</h4>
                        <div v-if="event.featured_image" class="relative w-full max-w-md">
                            <img
                                :src="`/storage/${event.featured_image}`"
                                :alt="event.title"
                                class="w-full h-auto rounded-lg shadow-sm border border-gray-200"
                            />
                        </div>
                        <p v-else class="text-sm text-gray-500">Tidak ada gambar utama.</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-700">Deskripsi</h4>
                    <div class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none"
                         v-html="event.description || '<p>Tidak ada deskripsi.</p>'"></div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PencilIcon } from '@heroicons/vue/24/outline';

defineProps({
    event: {
        type: Object,
        required: true
    }
});

const getCategoryText = (category) => {
    const texts = {
        umum: 'Umum',
        pemerintahan: 'Pemerintahan',
        kegiatan: 'Kegiatan',
        pengumuman: 'Pengumuman'
    };
    return texts[category] || category || '-';
};

const getStatusClass = (status) => {
    const classes = {
        upcoming: 'bg-blue-100 text-blue-800',
        ongoing: 'bg-green-100 text-green-800',
        completed: 'bg-gray-100 text-gray-800',
        cancelled: 'bg-red-100 text-red-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusText = (status) => {
    const texts = {
        upcoming: 'Akan Datang',
        ongoing: 'Berlangsung',
        completed: 'Selesai',
        cancelled: 'Dibatalkan'
    };
    return texts[status] || status || '-';
};

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<style>
.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
}
</style>
