<template>
    <GuestLayout title="Pengaduan Berhasil Dikirim">

        <Head title="Pengaduan Berhasil Dikirim" />

        <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div class="text-center">
                    <!-- Success Icon -->
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                        <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        Pengaduan Berhasil Dikirim!
                    </h2>

                    <p class="text-gray-600 mb-8">
                        Terima kasih telah menyampaikan pengaduan. Kami akan menindaklanjuti dalam 3x24 jam.
                    </p>

                    <!-- Complaint Number -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <p class="text-sm text-gray-600 mb-2">Nomor Tiket Pengaduan Anda</p>
                        <div class="bg-gray-50 rounded-lg p-4 border-2 border-dashed border-gray-300">
                            <p class="text-2xl font-mono font-bold text-gray-900 tracking-wider">
                                {{ complaintNumber }}
                            </p>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Simpan nomor ini untuk melacak status pengaduan
                        </p>
                    </div>

                    <!-- Next Steps -->
                    <div class="bg-blue-50 rounded-lg p-6 mb-8 text-left">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Langkah Selanjutnya</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">1</span>
                                <span class="text-blue-800">Pengaduan Anda akan diverifikasi oleh petugas</span>
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">2</span>
                                <span class="text-blue-800">Tim terkait akan menindaklanjuti pengaduan</span>
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">3</span>
                                <span class="text-blue-800">Anda akan mendapat notifikasi melalui email</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <Link :href="route('complaints.check')"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Cek Status Pengaduan
                        </Link>

                        <Link :href="route('home')"
                            class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Kembali ke Beranda
                        </Link>
                    </div>

                    <!-- Contact Info -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Butuh bantuan?</p>
                        <div class="flex justify-center space-x-6 text-sm">
                            <a href="tel:0274123456" class="text-blue-600 hover:text-blue-800">
                                📞 0274-123456
                            </a>
                            <a href="mailto:pengaduan@desa.go.id" class="text-blue-600 hover:text-blue-800">
                                ✉️ pengaduan@desa.go.id
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

defineProps({
    complaintNumber: String
})
</script>
