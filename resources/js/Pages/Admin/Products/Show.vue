<template>
    <AdminLayout title="Detail Produk UMKM">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Detail Produk UMKM</h3>
                <div class="flex space-x-2">
                    <Link :href="route('admin.products.edit', product.id)"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    <PencilIcon class="w-5 h-5 inline mr-2" />
                    Edit
                    </Link>
                    <Link :href="route('admin.products.index')"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    Kembali
                    </Link>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <p class="mt-1 text-sm text-gray-900">{{ product.name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <p class="mt-1 text-sm text-gray-900">{{ getCategoryText(product.category) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="getStatusClass(product.status)">
                                {{ getStatusText(product.status) }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga</label>
                            <p class="mt-1 text-sm text-gray-900">Rp {{ formatPrice(product.price) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok</label>
                            <p class="mt-1 text-sm text-gray-900">{{ product.stock }} unit</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Penjual</label>
                            <p class="mt-1 text-sm text-gray-900">{{ product.owner_name }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                        <div v-if="product.images && product.images.length > 0" class="grid grid-cols-2 gap-4">
                            <div
                                v-for="(image, idx) in product.images"
                                :key="image.id"
                                class="aspect-square rounded-xl overflow-hidden cursor-pointer group"
                                @click="openImageLightbox(`/storage/${image.image_url}`, idx)"
                            >
                                <LazyImage
                                    :src="`/storage/${image.image_url}`"
                                    :alt="image.caption || product.name"
                                    imageClass="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                            </div>
                        </div>
                        <div v-else class="text-sm text-gray-500">Tidak ada gambar produk</div>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ product.description }}</div>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div v-if="lightboxOpen"
            class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-90 flex items-center justify-center">
            <div class="relative max-w-4xl w-full p-4">
                <button @click="lightboxOpen = false"
                    class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
                    &times;
                </button>

                <div class="flex items-center justify-center">
                    <button @click="prevImage" class="text-white text-4xl px-4 hover:text-gray-300">&lt;</button>

                    <div class="relative">
                        <LazyImage
                            :src="product.images[currentImageIndex].image_url || '/placeholder.svg?height=600&width=800'"
                            :alt="`Product image ${currentImageIndex + 1}`"
                            imageClass="max-h-[80vh] max-w-full object-contain"
                        />
                        <p v-if="product.images[currentImageIndex].caption" class="text-white text-center mt-2">
                            {{ product.images[currentImageIndex].caption }}
                        </p>
                    </div>

                    <button @click="nextImage" class="text-white text-4xl px-4 hover:text-gray-300">&gt;</button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { PencilIcon } from '@heroicons/vue/24/outline'
import LazyImage from '@/Components/LazyImage.vue'

const props = defineProps({
    product: Object
})

const lightboxOpen = ref(false)
const currentImageIndex = ref(0)
const lightbox = ref(null)

const getCategoryText = (category) => {
    const texts = {
        food: 'Makanan',
        craft: 'Kerajinan',
        agriculture: 'Pertanian',
        fashion: 'Fashion',
        other: 'Lainnya'
    }
    return texts[category] || category
}

const getStatusClass = (status) => {
    const classes = {
        draft: 'bg-gray-100 text-gray-800',
        published: 'bg-green-100 text-green-800',
        sold_out: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
    const texts = {
        draft: 'Draft',
        published: 'Dipublikasi',
        sold_out: 'Habis'
    }
    return texts[status] || status
}

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID').format(price)
}

const openImageLightbox = (url, index = 0) => {
    const images = props.product.images.map(img => ({
        url: `/storage/${img.image_url}`,
        caption: img.caption || props.product.name
    }))
    const idx = images.findIndex(img => img.url === url)
    lightbox.value.openLightbox(images, idx !== -1 ? idx : 0)
}

const nextImage = () => {
    if (currentImageIndex.value < props.product.images.length - 1) {
        currentImageIndex.value++
    } else {
        currentImageIndex.value = 0
    }
}

const prevImage = () => {
    if (currentImageIndex.value > 0) {
        currentImageIndex.value--
    } else {
        currentImageIndex.value = props.product.images.length - 1
    }
}
</script>
