<template>
    <AdminLayout :title="`Detail Galeri: ${gallery.title}`">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Detail Galeri</h3>
                <div class="flex space-x-2">
                    <Link :href="route('admin.galleries.edit', gallery.id)"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    <PencilIcon class="w-5 h-5 inline mr-2" />
                    Edit
                    </Link>
                    <Link :href="route('admin.galleries.index')"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    Kembali
                    </Link>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Galeri</label>
                            <p class="mt-1 text-sm text-gray-900">{{ gallery.title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ gallery.description || 'Tidak ada deskripsi' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="gallery.is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                {{ gallery.is_published ? 'Dipublikasi' : 'Draft' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Galeri</label>
                        <div v-if="gallery.images && gallery.images.length > 0"
                            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div v-for="(image, index) in gallery.images" :key="index" class="space-y-1">
                                <LazyImage
                                    :src="`/storage/${image.image_path}`"
                                    :alt="`Gallery image ${index + 1}`"
                                    imageClass="w-full h-40 object-cover rounded-lg cursor-pointer"
                                    @click="openLightbox(index)"
                                />
                                <p v-if="image.caption" class="text-xs text-gray-600 truncate">{{ image.caption }}</p>
                            </div>
                        </div>
                        <div v-else class="text-sm text-gray-500">Tidak ada gambar dalam galeri ini</div>
                    </div>
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
                            :src="gallery.images[currentImageIndex].image_path || '/placeholder.svg?height=600&width=800'"
                            :alt="`Gallery image ${currentImageIndex + 1}`"
                            imageClass="max-h-[80vh] max-w-full object-contain"
                        />
                        <p v-if="gallery.images[currentImageIndex].caption" class="text-white text-center mt-2">
                            {{ gallery.images[currentImageIndex].caption }}
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
    gallery: Object
})

const lightboxOpen = ref(false)
const currentImageIndex = ref(0)

const openLightbox = (index) => {
    currentImageIndex.value = index
    lightboxOpen.value = true
}

const nextImage = () => {
    if (currentImageIndex.value < props.gallery.images.length - 1) {
        currentImageIndex.value++
    } else {
        currentImageIndex.value = 0
    }
}

const prevImage = () => {
    if (currentImageIndex.value > 0) {
        currentImageIndex.value--
    } else {
        currentImageIndex.value = props.gallery.images.length - 1
    }
}
</script>
