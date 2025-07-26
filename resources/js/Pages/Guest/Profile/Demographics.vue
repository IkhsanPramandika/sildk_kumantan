<template>
    <GuestLayout title="Demografi Desa">
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">DEMOGRAFI PENDUDUK</h1>
                    <p class="text-xl text-red-100 opacity-90">
                        Data Kependudukan dan Statistik Demografis Desa Anda
                    </p>
                </div>
            </div>
        </div>

        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-red-600 mr-4"></div>
                        <h2 class="text-xl font-bold text-red-600">JUMLAH PENDUDUK DAN KEPALA KELUARGA</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow-md p-6 text-center border">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <UsersIcon class="w-8 h-8 text-blue-600" />
                            </div>
                            <h3 class="text-gray-600 text-sm font-medium mb-2">TOTAL PENDUDUK</h3>
                            <p class="text-3xl font-bold text-red-600">{{ totalPopulation }}</p>
                            <p class="text-sm text-gray-500">Jiwa</p>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-6 text-center border">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <MapPinIcon class="w-8 h-8 text-red-600" />
                            </div>
                            <h3 class="text-gray-600 text-sm font-medium mb-2">KEPALA KELUARGA</h3>
                            <p class="text-3xl font-bold text-red-600">{{ totalFamilies }}</p>
                            <p class="text-sm text-gray-500">Jiwa</p>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-6 text-center border">
                            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <UserIcon class="w-8 h-8 text-pink-600" />
                            </div>
                            <h3 class="text-gray-600 text-sm font-medium mb-2">PEREMPUAN</h3>
                            <p class="text-3xl font-bold text-red-600">{{ femalePopulation }}</p>
                            <p class="text-sm text-gray-500">Jiwa</p>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-6 text-center border">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <UserIcon class="w-8 h-8 text-blue-600" />
                            </div>
                            <h3 class="text-gray-600 text-sm font-medium mb-2">LAKI-LAKI</h3>
                            <p class="text-3xl font-bold text-red-600">{{ malePopulation }}</p>
                            <p class="text-sm text-gray-500">Jiwa</p>
                        </div>
                    </div>

                    <!-- Grafik Gender -->
                    <div class="max-w-xl mx-auto mt-8">
                        <PieChart :labels="['Perempuan', 'Laki-laki']" :values="[femalePopulation, malePopulation]" title="Perbandingan Gender" />
                    </div>
                </div>

                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-red-600 mr-4"></div>
                        <h2 class="text-xl font-bold text-red-600">BERDASARKAN PEKERJAAN</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div v-for="(job, index) in jobStatistics" :key="job.type" class="bg-white rounded-lg shadow-md p-6 text-center border" :class="{'bg-gray-50': index % 2 === 0}">
                            <h3 class="text-gray-600 text-sm font-medium mb-2">{{ job.type }}</h3>
                            <p class="text-3xl font-bold text-red-600">{{ job.count }}</p>
                        </div>
                        <div v-if="jobStatistics.length === 0" class="col-span-full text-center text-gray-500">
                            <p>Tidak ada data pekerjaan untuk ditampilkan dalam kartu.</p>
                        </div>
                    </div>
                </div>

                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-red-600 mr-4"></div>
                        <h2 class="text-xl font-bold text-red-600">BERDASARKAN PENDIDIKAN</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div v-for="education in educationStatistics" :key="education.level"
                             class="bg-white rounded-lg shadow-md p-6 text-center border">
                            <h3 class="text-gray-600 text-sm font-medium mb-2">{{ education.level }}</h3>
                            <p class="text-3xl font-bold text-red-600">{{ education.count }}</p>
                        </div>
                        <div v-if="educationStatistics.length === 0" class="md:col-span-3 text-center text-gray-500">
                            <p>Belum ada data pendidikan.</p>
                        </div>
                    </div>

                    <!-- Grafik Pendidikan -->
                    <div class="max-w-2xl mx-auto mt-8">
                        <BarChart :labels="educationStatistics.map(e => e.level)" :values="educationStatistics.map(e => e.count)" title="Distribusi Pendidikan" />
                    </div>
                </div>

                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-red-600 mr-4"></div>
                        <h2 class="text-xl font-bold text-red-600">BERDASARKAN USIA</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div v-for="age in ageStatistics" :key="age.range"
                             class="bg-white rounded-lg shadow-md p-6 text-center border">
                            <h3 class="text-gray-600 text-sm font-medium mb-2">{{ age.range }}</h3>
                            <p class="text-3xl font-bold text-red-600">{{ age.count }}</p>
                        </div>
                        <div v-if="ageStatistics.length === 0" class="md:col-span-4 text-center text-gray-500">
                            <p>Belum ada data usia.</p>
                        </div>
                    </div>

                    <!-- Grafik Usia -->
                    <div class="max-w-2xl mx-auto mt-8">
                        <BarChart :labels="ageStatistics.map(a => a.range)" :values="ageStatistics.map(a => a.count)" title="Distribusi Usia" />
                    </div>
                </div>

                <!-- Statistik Agama -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-red-600 mr-4"></div>
                        <h2 class="text-xl font-bold text-red-600">BERDASARKAN AGAMA</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div v-for="(religion, index) in religionStatistics" :key="religion.type"
                             class="bg-white rounded-lg shadow-md p-6 text-center border"
                             :class="getCardColorByIndex(index)">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                                 :class="getIconColorByIndex(index)">
                                <BuildingLibraryIcon class="w-8 h-8" :class="getIconTextColorByIndex(index)" />
                            </div>
                            <h3 class="text-gray-600 text-sm font-medium mb-2">{{ religion.type }}</h3>
                            <p class="text-3xl font-bold text-red-600">{{ religion.count }}</p>
                            <p class="text-sm text-gray-500">Jiwa</p>
                        </div>
                        <div v-if="religionStatistics.length === 0" class="col-span-full text-center text-gray-500">
                            <p>Belum ada data agama.</p>
                        </div>
                    </div>

                    <!-- Grafik Agama -->
                    <div class="max-w-2xl mx-auto mt-8">
                        <PieChart :labels="religionStatistics.map(r => r.type)" :values="religionStatistics.map(r => r.count)" title="Distribusi Agama" />
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { UsersIcon, UserIcon, MapPinIcon, BuildingLibraryIcon } from '@heroicons/vue/24/outline'
import BarChart from '@/Components/BarChart.vue'
import PieChart from '@/Components/PieChart.vue'
import SectionHeading from '@/Components/Guest/SectionHeading.vue'

defineProps({
    totalPopulation: {
        type: Number,
        required: true
    },
    malePopulation: {
        type: Number,
        required: true
    },
    femalePopulation: {
        type: Number,
        required: true
    },
    totalFamilies: {
        type: Number,
        required: true
    },
    jobStatistics: {
        type: Array,
        required: true
    },
    educationStatistics: {
        type: Array,
        required: true
    },
    ageStatistics: {
        type: Array,
        required: true
    },
    religionStatistics: {
        type: Array,
        required: true
    }
})

// Helper functions for card styling
const getCardColorByIndex = (index) => {
    const colors = ['bg-gray-50', 'bg-blue-50', 'bg-green-50', 'bg-purple-50', 'bg-yellow-50', 'bg-pink-50', 'bg-indigo-50']
    return colors[index % colors.length]
}

const getIconColorByIndex = (index) => {
    const colors = ['bg-gray-100', 'bg-blue-100', 'bg-green-100', 'bg-purple-100', 'bg-yellow-100', 'bg-pink-100', 'bg-indigo-100']
    return colors[index % colors.length]
}

const getIconTextColorByIndex = (index) => {
    const colors = ['text-gray-600', 'text-blue-600', 'text-green-600', 'text-purple-600', 'text-yellow-600', 'text-pink-600', 'text-indigo-600']
    return colors[index % colors.length]
}
</script>
