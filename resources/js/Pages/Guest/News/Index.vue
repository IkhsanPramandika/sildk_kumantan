<template>
    <GuestLayout title="Berita">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">Berita Terbaru</h1>
                    <p class="text-xl text-red-100 opacity-90">
                        Informasi terkini seputar kegiatan dan perkembangan desa
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Search and Filter -->
                <div class="max-w-4xl mx-auto mb-12">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1 relative">
                                <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari berita..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                />
                            </div>
                            <select
                                v-model="filters.category"
                                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            >
                                <option value="">Semua Kategori</option>
                                <option value="umum">Umum</option>
                                <option value="pemerintahan">Pemerintahan</option>
                                <option value="kegiatan">Kegiatan</option>
                                <option value="pengumuman">Pengumuman</option>
                            </select>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            Menampilkan {{ filteredNews.length }} dari {{ news.length }} berita
                        </div>
                    </div>
                </div>

                <!-- News Grid -->
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <article
                            v-for="newsItem in filteredNews"
                            :key="newsItem.id"
                            class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group"
                        >
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden">
                                <LazyImage
                                    :src="`/storage/${newsItem.image_url}`"
                                    :alt="newsItem.title"
                                    height="200px"
                                    imageClass="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                    <Link :href="route('news.show', { news: newsItem.slug })">
                                        {{ newsItem.title }}
                                    </Link>
                                </h3>
                                <div class="text-gray-600 mb-4 prose prose-sm max-w-none" v-html="getExcerpt(newsItem.content)"></div>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ formatDate(newsItem.publish_date) }}</span>
                                    <Link :href="route('news.show', { news: newsItem.slug })"
                                          class="text-blue-600 hover:text-blue-800 font-medium">
                                        Baca Selengkapnya
                                    </Link>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredNews.length === 0" class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <NewspaperIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada berita ditemukan</h3>
                            <p class="text-gray-600 mb-6">
                                {{ searchQuery ? 'Coba ubah kata kunci pencarian Anda' : 'Belum ada berita yang dipublikasikan' }}
                            </p>
                            <button
                                v-if="searchQuery || filters.category"
                                @click="clearFilters"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                            >
                                Hapus Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';
import LazyImage from '@/Components/LazyImage.vue';
import {
    MagnifyingGlassIcon,
    NewspaperIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    news: Array
});

const searchQuery = ref('');
const filters = ref({
    category: ''
});

const filteredNews = computed(() => {
    let filtered = props.news.data;

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(item =>
            item.title.toLowerCase().includes(query) ||
            item.content.toLowerCase().includes(query)
        );
    }

    if (filters.value.category) {
        filtered = filtered.filter(item => item.category === filters.value.category);
    }

    return filtered;
});

const clearFilters = () => {
    searchQuery.value = '';
    filters.value.category = '';
};

const getCategoryText = (category) => {
    const texts = {
        umum: 'Umum',
        pemerintahan: 'Pemerintahan',
        kegiatan: 'Kegiatan',
        pengumuman: 'Pengumuman'
    };
    return texts[category] || category;
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const getExcerpt = (content) => {
    if (!content) return '';
    const text = content.replace(/<[^>]*>/g, '');
    return text.length > 150 ? text.substring(0, 150) + '...' : text;
};
</script>
