<template>
    <AdminLayout title="Detail Berita">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Detail Berita</h3>
                <div class="flex space-x-2">
                    <Link :href="route('admin.news.edit', news.id)"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 flex items-center">
                        <PencilIcon class="w-5 h-5 mr-2" />
                        Edit
                    </Link>
                    <Link :href="route('admin.news.index')"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Kembali
                    </Link>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Judul Berita</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ news.title || '-' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Kategori</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ getCategoryText(news.category) }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Status</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="getStatusClass(news.status)">
                                {{ getStatusText(news.status) }}
                            </span>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Tanggal Publikasi</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ formatDate(news.publish_date) }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Gambar Utama Berita</h4>
                        <div v-if="news.featured_image" class="relative w-full max-w-md">
                            <img
                                :src="`/storage/${news.featured_image}`"
                                alt="Gambar Utama Berita"
                                class="w-full h-auto rounded-lg shadow-sm border border-gray-200"
                            />
                        </div>
                        <p v-else class="text-sm text-gray-500">Tidak ada gambar utama.</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-700">Konten Berita</h4>
                    <div class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none"
                         v-html="news.content || '<p>Tidak ada konten.</p>'"></div>
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
    news: {
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
        draft: 'bg-gray-100 text-gray-800',
        published: 'bg-green-100 text-green-800',
        archived: 'bg-yellow-100 text-yellow-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusText = (status) => {
    const texts = {
        draft: 'Draft',
        published: 'Dipublikasi',
        archived: 'Diarsipkan'
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
