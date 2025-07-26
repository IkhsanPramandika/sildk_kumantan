<template>
    <GuestLayout title="Sumber Daya Alam">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">Sumber Daya Alam</h1>
                    <p class="text-xl text-red-100 opacity-90">
                        Potensi dan kekayaan alam yang dimiliki Desa Kumantan
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Error State -->
                <div v-if="error" class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
                    <div class="flex items-center">
                        <ExclamationTriangleIcon class="w-5 h-5 text-red-600 mr-2" />
                        <p class="text-red-800">{{ error }}</p>
                    </div>
                </div>

                <!-- Natural Resources Grid -->
                <div v-if="potentials.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="(potential, idx) in potentials" :key="potential.id"
                         class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="h-48 overflow-hidden cursor-pointer" @click="openImageLightbox(idx)">
                            <LazyImage
                                :src="potential.image ? `/storage/${potential.image}` : '/placeholder.svg?height=300&width=600&text=Potential+Cover'"
                                :alt="potential.title"
                                imageClass="w-full h-full object-cover"
                            />
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ potential.title }}</h3>
                            <div class="prose max-w-none text-gray-600 text-sm mb-4" v-html="potential.description"></div>
                            <Link :href="route('potentials.show', potential.id)"
                                  class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Lihat Detail
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-12 bg-white rounded-lg shadow-md">
                    <DocumentTextIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Data</h3>
                    <p class="text-gray-600">
                        Data sumber daya alam sedang dalam proses pengumpulan.
                    </p>
                </div>
            </div>
        </section>

        <!-- Lightbox -->
        <Lightbox ref="lightbox" />
    </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Lightbox from '@/Components/Lightbox.vue'
import { PhotoIcon, DocumentTextIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/vue3'
import LazyImage from '@/Components/LazyImage.vue'

const props = defineProps({
    potentials: {
        type: Array,
        default: () => []
    },
    error: {
        type: String,
        default: null
    }
})

const lightbox = ref(null)
const images = computed(() => props.potentials.map(item => ({
  url: item.image ? `/storage/${item.image}` : '/placeholder.svg?height=300&width=600&text=Potential+Cover',
  caption: item.title
})))

const openImageLightbox = (index = 0) => {
  lightbox.value.open(images.value, index)
}
</script>

<style scoped>
.bg-brown-100 {
    background-color: #f3e8d3;
}
.text-brown-600 {
    color: #92400e;
}
</style>
