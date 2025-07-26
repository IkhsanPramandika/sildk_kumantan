<template>
    <GuestLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Hero Section -->
                <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-lg shadow-xl overflow-hidden mb-8">
                    <div class="px-6 py-12 sm:px-12 text-center">
                        <h1 class="text-3xl font-bold text-white mb-4">Sejarah & Wilayah Desa Kumantan</h1>
                        <p class="text-red-100 max-w-3xl mx-auto">
                            Menelusuri perjalanan panjang, perkembangan desa, dan informasi geografis wilayah Desa Kumantan, Kecamatan Bangkinang Kota, Kabupaten Kampar, Provinsi Riau
                        </p>
                    </div>
                </div>

                <!-- Sejarah Desa Section -->
                <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-red-600 mr-4"></div>
                        <h2 class="text-2xl font-bold text-red-600">SEJARAH DESA</h2>
                    </div>

                    <template v-if="error">
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                                <ExclamationCircleIcon class="w-8 h-8 text-red-600" />
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Terjadi Kesalahan</h3>
                            <p class="text-gray-600">{{ error }}</p>
                        </div>
                    </template>

                    <template v-else-if="villageProfile">
                        <div v-if="villageProfile.history_image" class="mb-8 flex flex-col items-center">
                            <div class="rounded-lg overflow-hidden cursor-pointer max-w-xl w-full" @click="openImageLightbox()">
                                <LazyImage
                                    :src="`/storage/${villageProfile.history_image}`"
                                    :alt="villageProfile.history_image_caption || 'Foto sejarah desa'"
                                    imageClass="w-full h-64 object-cover"
                                />
                            </div>
                            <div v-if="villageProfile.history_image_caption" class="text-xs text-gray-600 mt-2 text-center max-w-xl">{{ villageProfile.history_image_caption }}</div>
                            <Lightbox ref="lightbox" />
                        </div>
                        <div class="prose prose-lg max-w-none">
                            <div v-html="villageProfile.history"></div>
                        </div>
                    </template>

                    <template v-else>
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <DocumentTextIcon class="w-8 h-8 text-gray-600" />
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Data</h3>
                            <p class="text-gray-600">Sejarah desa sedang dalam proses pengumpulan data.</p>
                        </div>
                    </template>
                </div>

                <!-- Wilayah Desa Section -->
                <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-red-600 mr-4"></div>
                        <h2 class="text-2xl font-bold text-red-600">WILAYAH DESA</h2>
                    </div>

                    <!-- Map Container -->
                    <div class="bg-gray-100 rounded-lg p-6 mb-8">
                        <div class="aspect-video bg-white rounded-lg overflow-hidden">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.9797826981!2d101.0402485!3d0.347484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5144706e1be3b%3A0xc3a734689a98c168!2sKumantan%2C%20Kec.%20Bangkinang%2C%20Kabupaten%20Kampar%2C%20Riau!5e0!3m2!1sid!2sid!4v1749914372584!5m2!1sid!2sid"
                                class="w-full h-full"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="https://gis.dukcapil.kemendagri.go.id/peta"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium">
                                <MapIcon class="w-5 h-5 mr-2" />
                                Buka Peta GIS Dukcapil
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Territory Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Luas Wilayah:</span>
                                    <span class="font-medium">{{ territoryInfo.area }} km²</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ketinggian:</span>
                                    <span class="font-medium">{{ territoryInfo.altitude }} mdpl</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jumlah RT:</span>
                                    <span class="font-medium">{{ 24 }} RT</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jumlah RW:</span>
                                    <span class="font-medium">{{ 7 }} RW</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kode Pos:</span>
                                    <span class="font-medium">{{ territoryInfo.postal_code }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Boundaries -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Batas Wilayah</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Utara:</span>
                                    <span class="font-medium">{{ boundaries.north }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Selatan:</span>
                                    <span class="font-medium">{{ boundaries.south }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Timur:</span>
                                    <span class="font-medium">{{ boundaries.east }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Barat:</span>
                                    <span class="font-medium">{{ boundaries.west }}</span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ExclamationCircleIcon, DocumentTextIcon, MapIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue'
import LazyImage from '@/Components/LazyImage.vue'
import Lightbox from '@/Components/Lightbox.vue'

const props = defineProps({
    villageProfile: Object,
    error: String,
    territoryInfo: {
        type: Object,
        default: () => ({
            area: '15.5',
            altitude: '35',
            rt_count: 24,
            rw_count: 7,
            postal_code: '28412'
        })
    },
    boundaries: {
        type: Object,
        default: () => ({
            north: 'Kelurahan Bangkinang',
            south: 'Desa Pulau Lawas',
            east: 'Desa Batu Belah',
            west: 'Kelurahan Langgini'
        })
    }
})

const lightbox = ref(null)
const openImageLightbox = () => {
  if (props.villageProfile.history_image) {
    lightbox.value.open(props.villageProfile.history_image, props.villageProfile.history_image_caption)
  }
}
</script>
