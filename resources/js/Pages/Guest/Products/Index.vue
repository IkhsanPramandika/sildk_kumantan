<template>
    <GuestLayout title="Produk UMKM">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">Produk UMKM Desa</h1>
                    <p class="text-xl text-red-100 opacity-90">
                        Produk unggulan dan hasil karya masyarakat desa
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
                                    placeholder="Cari produk..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                />
                            </div>
                            <select
                                v-model="filters.category"
                                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            >
                                <option value="">Semua Kategori</option>
                                <option value="makanan">Makanan</option>
                                <option value="kerajinan">Kerajinan</option>
                                <option value="pertanian">Pertanian</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <select
                                v-model="sortBy"
                                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            >
                                <option value="newest">Terbaru</option>
                                <option value="name">Nama A-Z</option>
                                <option value="price_low">Harga Terendah</option>
                                <option value="price_high">Harga Tertinggi</option>
                            </select>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            Menampilkan {{ filteredProducts.length }} dari {{ products.length }} produk
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        <article
                            v-for="product in filteredProducts"
                            :key="product.id"
                            class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group"
                        >
                            <!-- Image -->
                            <div class="relative overflow-hidden">
                                <LazyImage
                                    :src="`/storage/${product.image_url}`"
                                    :alt="product.name"
                                    height="200px"
                                    imageClass="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/90 text-gray-800 text-xs font-semibold rounded-full">
                                        {{ getCategoryText(product.category) }}
                                    </span>
                                </div>

                                <!-- Quick View Button -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <Link
                                        :href="route('potentials.umkm.show', product.id)"
                                        class="px-4 py-2 bg-white text-gray-900 rounded-lg font-medium hover:bg-gray-100 transition-colors"
                                    >
                                        Lihat Detail
                                    </Link>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Title -->
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-red-600 transition-colors duration-200">
                                    {{ product.name }}
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ product.description || 'Deskripsi produk tidak tersedia' }}
                                </p>

                                <!-- Price -->
                                <div class="flex items-center justify-between">
                                    <div class="text-xl font-bold text-red-600">
                                        {{ formatPrice(product.price) }}
                                    </div>
                                    <Link
                                        :href="route('potentials.umkm.show', product.id)"
                                        class="text-red-600 hover:text-red-700 font-medium text-sm group/link"
                                    >
                                        Detail
                                        <ArrowRightIcon class="w-4 h-4 inline ml-1 group-hover/link:translate-x-1 transition-transform duration-200" />
                                    </Link>
                                </div>

                                <!-- Seller Info -->
                                <div v-if="product.seller" class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <UserIcon class="w-4 h-4 mr-1" />
                                        <span>{{ product.seller }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredProducts.length === 0" class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <ShoppingBagIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                            <p class="text-gray-600 mb-6">
                                {{ searchQuery ? 'Coba ubah kata kunci pencarian Anda' : 'Belum ada produk yang tersedia' }}
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

        <!-- CTA Section -->
        <!-- <section class="py-16 bg-red-600"> -->
            <!-- <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">Ingin Menjual Produk Anda?</h2>
                    <p class="text-xl text-red-100 mb-8">
                        Daftarkan produk UMKM Anda untuk dipromosikan melalui website desa
                    </p>
                    <Link
                        :href="route('contact')"
                        class="inline-flex items-center px-8 py-4 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors"
                    >
                        Daftar Sekarang
                        <ArrowRightIcon class="w-5 h-5 ml-2" />
                    </Link>
                </div>
            </div>
        </section> -->
    </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';
import LazyImage from '@/Components/LazyImage.vue';
import {
    MagnifyingGlassIcon,
    ArrowRightIcon,
    ShoppingBagIcon,
    UserIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
});

const searchQuery = ref('');
const filters = ref({
    category: ''
});
const sortBy = ref('newest');

console.log(props.products);

const filteredProducts = computed(() => {
    let filtered = Array.isArray(props.products.data) ? [...props.products.data] : [];

    // Search filter
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(product =>
            product.name.toLowerCase().includes(query) ||
            product.description?.toLowerCase().includes(query) ||
            product.category?.toLowerCase().includes(query)
        );
    }

    // Category filter
    if (filters.value.category) {
        filtered = filtered.filter(product =>
            product.category?.toLowerCase() === filters.value.category.toLowerCase()
        );
    }

    // Sort
    switch (sortBy.value) {
        case 'name':
            filtered.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'price_low':
            filtered.sort((a, b) => a.price - b.price);
            break;
        case 'price_high':
            filtered.sort((a, b) => b.price - a.price);
            break;
        case 'newest':
        default:
            filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            break;
    }

    return filtered;
});

const clearFilters = () => {
    searchQuery.value = '';
    filters.value.category = '';
    sortBy.value = 'newest';
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(price);
};

const getCategoryText = (category) => {
    const categories = {
        makanan: 'Makanan',
        kerajinan: 'Kerajinan',
        pertanian: 'Pertanian',
        lainnya: 'Lainnya'
    };
    return categories[category?.toLowerCase()] || 'Lainnya';
};
</script>
