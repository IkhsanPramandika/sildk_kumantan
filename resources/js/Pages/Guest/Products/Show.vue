<template>
    <GuestLayout :title="product.name">
        <div class="relative">
            <div v-if="product.image_url" class="h-64 md:h-96 w-full bg-gray-100 overflow-hidden cursor-pointer"
                @click="openImageLightbox(0)">
                <LazyImage :src="product.image_url" :alt="product.name" imageClass="w-full h-full object-cover" />
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

            <div class="absolute top-4 left-0 w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm">
                            <li>
                                <Link :href="route('home')" class="text-white/80 hover:text-white transition-colors">
                                Beranda
                                </Link>
                            </li>
                            <li>
                                <ChevronRightIcon class="w-4 h-4 text-white/60" />
                            </li>
                            <li>
                                <Link :href="route('potentials.umkm')"
                                    class="text-white/80 hover:text-white transition-colors">
                                Produk UMKM
                                </Link>
                            </li>
                            <li>
                                <ChevronRightIcon class="w-4 h-4 text-white/60" />
                            </li>
                            <li class="text-white font-medium truncate max-w-xs">
                                {{ product.name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-2/3">
                    <div v-if="product.images && product.images.length > 0" class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-200">Galeri Produk
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div v-for="(image, idx) in product.images" :key="image.id"
                                class="aspect-square rounded-xl overflow-hidden cursor-pointer group"
                                @click="openImageLightbox(idx)">
                                <LazyImage :src="`/storage/${image.image_url}`" :alt="image.caption || product.name"
                                    imageClass="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-200">Deskripsi Produk
                        </h2>
                        <div class="prose max-w-none text-gray-600" v-html="product.description"></div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6 mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Produk</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Kategori</h3>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ getCategoryName(product.category)
                                }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Harga</h3>
                                <p class="mt-1 text-2xl font-bold text-red-600">Rp {{ formatPrice(product.price) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/3">
                    <div class="sticky top-6 space-y-6">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Penjual</h3>
                                <div class="flex items-center space-x-4 mb-6">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                            {{ product.owner_name.charAt(0) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">{{ product.owner_name }}</h4>
                                        <p class="text-sm text-gray-500">{{ product.owner_address }}</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Kontak WhatsApp</p>
                                        <a :href="`https://wa.me/${product.formatted_phone}`" target="_blank"
                                            class="inline-flex items-center justify-center w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                            <PhoneIcon class="w-5 h-5 mr-2" />
                                            Hubungi Penjual
                                        </a>
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Alamat</p>
                                        <p class="text-gray-700">{{ product.owner_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Lightbox ref="lightbox" :isOpen="isLightboxOpen" :images="lightboxImages" :initialIndex="lightboxInitialIndex"
            @close="closeLightbox" />
    </GuestLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import LazyImage from '@/Components/LazyImage.vue'
import Lightbox from '@/Components/Lightbox.vue' // Ensure this path is correct
import { ChevronRightIcon, PhoneIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})

// Lightbox state variables
const isLightboxOpen = ref(false)
const lightboxImages = ref([])
const lightboxInitialIndex = ref(0)
const lightbox = ref(null)

const getStatusBadgeClass = (product) => {
    switch (product.status) {
        case 'available':
            return 'bg-green-100 text-green-800'
        case 'sold_out':
            return 'bg-red-100 text-red-800'
        case 'coming_soon':
            return 'bg-yellow-100 text-yellow-800'
        default:
            return 'bg-gray-100 text-gray-800'
    }
}

const getStatusTextColor = (product) => {
    switch (product.status) {
        case 'available':
            return 'text-green-600'
        case 'sold_out':
            return 'text-red-600'
        case 'coming_soon':
            return 'text-yellow-600'
        default:
            return 'text-gray-600'
    }
}

const getCategoryName = (categoryKey) => {
    const categoryMap = {
        'food': 'Makanan',
        'craft': 'Kerajinan Tangan',
        'agriculture': 'Pertanian',
        'fashion': 'Fesyen',
        'other': 'Lain-lain'
    }
    return categoryMap[categoryKey] || 'Lain-lain'
}

const getStatusText = (product) => {
    switch (product.status) {
        case 'available':
            return 'Tersedia'
        case 'sold_out':
            return 'Habis'
        case 'coming_soon':
            return 'Segera Hadir'
        default:
            return 'Tidak Tersedia'
    }
}

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID').format(price)
}

const openImageLightbox = (index = 0) => {
    // Include the main product image in the lightbox images
    const allImages = [
        { url: window.location.origin + props.product.image_url, caption: props.product.name },
        ...props.product.images.map(img => ({
            url: window.location.origin + `/storage/${img.image_url}`,
            caption: img.caption || props.product.name
        }))
    ]
    lightboxImages.value = allImages
    lightboxInitialIndex.value = index
    isLightboxOpen.value = true
}

const closeLightbox = () => {
    isLightboxOpen.value = false
}
</script>

<style scoped>
/* Custom scrollbar for description */
.prose::-webkit-scrollbar {
    width: 6px;
}

.prose::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.prose::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.prose::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
