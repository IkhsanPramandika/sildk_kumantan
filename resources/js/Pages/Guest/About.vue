<template>
    <GuestLayout title="Tentang Desa">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">Tentang Desa {{ villageProfile.name }}</h1>
                    <p class="text-xl text-red-100 opacity-90">Mengenal lebih dekat desa kami, sejarah, dan perkembangannya</p>
                </div>
            </div>
        </div>

        <!-- Village Profile Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <div class="inline-block p-4 bg-red-50 rounded-2xl mb-6">
                            <LazyImage
                                :src="villageProfile.logo || '/placeholder.svg?height=128&width=128'"
                                alt="Logo Desa"
                                imageClass="w-32 h-32 object-contain"
                            />
                        </div>
                    </div>

                    <div>
                        <div class="mb-6">
                            <span class="inline-block px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-medium mb-4">
                                Profil Desa
                            </span>
                            <h2 class="text-3xl font-bold text-gray-900">{{ villageProfile.name || 'Nama Desa' }}</h2>
                        </div>

                        <div class="prose prose-lg max-w-none mb-8">
                            <p class="text-gray-700 leading-relaxed">
                                {{ villageProfile.description || 'Deskripsi desa belum ditambahkan' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Kepala Desa</h3>
                                <p class="text-gray-700">{{ villageProfile.head_name || 'Belum ditambahkan' }}</p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h3>
                                <p class="text-gray-700">
                                    {{ villageProfile.address || 'Belum ditambahkan' }}
                                    <span v-if="villageProfile.rt && villageProfile.rw">
                                        RT {{ villageProfile.rt }}/RW {{ villageProfile.rw }}
                                    </span>
                                </p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Kecamatan/Kota</h3>
                                <p class="text-gray-700">
                                    {{ [villageProfile.district, villageProfile.city].filter(Boolean).join(', ') || 'Belum ditambahkan' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Provinsi</h3>
                                <p class="text-gray-700">{{ villageProfile.province || 'Belum ditambahkan' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto">
                    <SectionHeading title="Visi & Misi" subtitle="Arah dan tujuan pembangunan desa kami" />

                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi</h3>
                            <div class="prose prose-lg max-w-none">
                                <p class="text-gray-700">{{ villageProfile.vision || 'Visi desa belum ditambahkan' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi</h3>
                            <div class="prose prose-lg max-w-none">
                                <div v-if="villageProfile.mission" class="text-gray-700"
                                    v-html="formatMission(villageProfile.mission)"></div>
                                <p v-else class="text-gray-700">Misi desa belum ditambahkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organization Structure Section -->
        <section v-if="villageProfile.organization_structure" class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <SectionHeading title="Struktur Organisasi" subtitle="Susunan kepengurusan desa" />

                <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200 max-w-4xl mx-auto">
                    <LazyImage
                        :src="villageProfile.organization_structure"
                        alt="Struktur Organisasi Desa"
                        imageClass="w-full h-auto rounded-lg shadow-sm"
                    />
                    <p class="text-center text-sm text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                </div>
            </div>
        </section>

        <!-- Modal for Organization Structure -->
        <div v-if="openOrganizationStructure"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75">
            <div class="relative bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-auto">
                <button @click="openOrganizationStructure = false"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    <XMarkIcon class="w-6 h-6" />
                </button>
                <div class="p-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Struktur Organisasi Desa</h3>
                    <LazyImage
                        :src="villageProfile.organization_structure"
                        alt="Struktur Organisasi Desa"
                        imageClass="w-full h-auto rounded-lg shadow-sm"
                    />
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <StatCard :icon="UsersIcon" :value="stats.total_residents" label="Total Penduduk" />
                    <StatCard :icon="UserIcon" :value="stats.total_male" label="Laki-laki" />
                    <StatCard :icon="UserIcon" :value="stats.total_female" label="Perempuan" />
                    <StatCard :icon="MapIcon" :value="stats.total_area" label="Luas Wilayah" suffix="km²" />
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-blue-600">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">Ingin Berpartisipasi?</h2>
                    <p class="text-xl text-white opacity-90 mb-8 max-w-3xl mx-auto">
                        Mari berpartisipasi dalam pembangunan desa dengan memberikan saran, kritik, atau ide untuk
                        kemajuan desa.
                    </p>
                    <Link :href="route('contact')"
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-gray-50">
                    Hubungi Kami
                    <ArrowRightIcon class="w-5 h-5 ml-2" />
                    </Link>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import SectionHeading from '@/Components/Guest/SectionHeading.vue'
import StatCard from '@/Components/Guest/StatCard.vue'
import {
    ArrowRightIcon,
    UsersIcon,
    UserIcon,
    MapIcon,
    BuildingOfficeIcon,
    XMarkIcon
} from '@heroicons/vue/24/outline'

const openOrganizationStructure = ref(false)

defineProps({
    villageProfile: {
        type: Object,
        default: () => ({})
    },
    stats: {
        type: Object,
        default: () => ({
            total_residents: 0,
            total_male: 0,
            total_female: 0,
            total_area: 0
        })
    }
})

const formatMission = (mission) => {
    // Jika mission adalah array, ubah menjadi list HTML
    if (Array.isArray(mission)) {
        return `<ul class="list-disc pl-5 space-y-2">
      ${mission.map(item => `<li>${item}</li>`).join('')}
    </ul>`
    }

    // Jika mission adalah string dengan baris baru, ubah menjadi list HTML
    if (typeof mission === 'string' && mission.includes('\n')) {
        const items = mission.split('\n').filter(item => item.trim() !== '')
        return `<ul class="list-disc pl-5 space-y-2">
      ${items.map(item => `<li>${item}</li>`).join('')}
    </ul>`
    }

    // Jika mission adalah string biasa, kembalikan apa adanya
    return mission
}
</script>
