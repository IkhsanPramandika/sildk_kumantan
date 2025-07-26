<template>
    <GuestLayout title="Buat Pengaduan">

        <Head title="Ajukan Pengaduan" />

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">Ajukan Pengaduan</h1>
                    <p class="text-xl text-red-100">
                        Sampaikan keluhan atau saran Anda untuk kemajuan desa
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Form Pengaduan</h2>
                        <p class="text-gray-600">
                            Isi form di bawah ini dengan lengkap dan jelas. Pengaduan Anda akan ditindaklanjuti dalam
                            3x24 jam.
                        </p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Induk Kependudukan (NIK) *
                            </label>
                            <input id="nik" v-model="form.nik" type="text" required maxlength="16"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="Masukkan NIK 16 digit" />
                            <div v-if="errors.nik" class="mt-1 text-sm text-red-600">
                                {{ errors.nik }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                NIK harus terdaftar dalam database penduduk desa
                            </p>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori Pengaduan *
                            </label>
                            <select id="category" v-model="form.category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">Pilih kategori pengaduan</option>
                                <option value="infrastructure">Infrastruktur</option>
                                <option value="service">Pelayanan</option>
                                <option value="social">Sosial</option>
                                <option value="economy">Ekonomi</option>
                                <option value="other">Lainnya</option>
                            </select>
                            <div v-if="errors.category" class="mt-1 text-sm text-red-600">
                                {{ errors.category }}
                            </div>
                        </div>

                        <!-- Judul -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Pengaduan *
                            </label>
                            <input id="title" v-model="form.title" type="text" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="Masukkan judul pengaduan yang singkat dan jelas" />
                            <div v-if="errors.title" class="mt-1 text-sm text-red-600">
                                {{ errors.title }}
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Pengaduan *
                            </label>
                            <textarea id="description" v-model="form.description" rows="6" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="Jelaskan pengaduan Anda secara detail..."></textarea>
                            <div v-if="errors.description" class="mt-1 text-sm text-red-600">
                                {{ errors.description }}
                            </div>
                        </div>

                        <!-- Upload Gambar -->
                        <div>
                            <FileUpload
                                label="Lampiran Gambar (opsional, jpg/png, maks 2MB)"
                                :multiple="false"
                                accept="image/*"
                                :show-captions="false"
                                v-model="selectedImages"
                                :error="form.errors.image"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <Link :href="route('home')"
                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Batal
                            </Link>
                            <button type="submit" :disabled="processing"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <span v-if="processing">Mengirim...</span>
                                <span v-else>Kirim Pengaduan</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Info Section -->
                <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penting</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Pastikan NIK yang dimasukkan sudah terdaftar dalam database penduduk desa
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Sertakan detail lengkap dan bukti pendukung jika ada
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Simpan nomor tiket pengaduan untuk melacak status
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Data pribadi Anda akan dijaga kerahasiaannya
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import FileUpload from '@/Components/FileUpload.vue'
import { ref } from 'vue'

const selectedImages = ref([])

const form = useForm({
    nik: '',
    category: '',
    title: '',
    description: '',
    image: null,
})

const submit = () => {
    if (selectedImages.value.length > 0) {
        form.image = selectedImages.value[0].file
    }

    form.post(route('complaints.store'))
}

defineProps({
    errors: Object
})
</script>
