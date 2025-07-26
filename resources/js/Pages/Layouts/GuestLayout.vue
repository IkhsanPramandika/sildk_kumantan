<template>
    <div class="hidden md:flex items-center space-x-8">
        <Link :href="route('home')" 
              class="text-gray-300 hover:text-white transition-colors duration-200"
              :class="{ 'text-white': $page.url === route('home') }">
            Beranda
        </Link>

        <div class="relative group">
            <button class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center space-x-1"
                    :class="{ 'text-white': $page.url.startsWith('/organization') }">
                <span>Organisasi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <Link :href="route('organization.history')" 
                      class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                      :class="{ 'bg-red-50 text-red-600': $page.url === route('organization.history') }">
                    Sejarah Desa 
                </Link> 
                <Link :href="route('organization.structure')" 
                      class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                      :class="{ 'bg-red-50 text-red-600': $page.url === route('organization.structure') }">
                    Struktur Pemerintahan
                </Link>
                <Link :href="route('organization.bpd')" 
                      class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                      :class="{ 'bg-red-50 text-red-600': $page.url === route('organization.bpd') }">
                    BPD
                </Link>
                <Link :href="route('organization.karang-taruna')" 
                      class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                      :class="{ 'bg-red-50 text-red-600': $page.url === route('organization.karang-taruna') }">
                    Karang Taruna
                </Link>
                <Link :href="route('organization.pkk')" 
                      class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                      :class="{ 'bg-red-50 text-red-600': $page.url === route('organization.pkk') }">
                    PKK
                </Link>
            </div>
        </div>

        <div class="relative group">
            <button class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center space-x-1"
                    :class="{ 'text-white': $page.url.startsWith('/potentials') }">
                <span>Potensi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <Link :href="route('potentials.natural-resources')" 
                      class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                      :class="{ 'bg-red-50 text-red-600': $page.url === route('potentials.natural-resources') }">
                    Sumber Daya Alam
                </Link>
                <Link :href="route('potentials.infrastructure')" 
                      class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                      :class="{ 'bg-red-50 text-red-600': $page.url === route('potentials.infrastructure') }">
                    Infrastruktur
                </Link>
            </div>
        </div>

        <Link :href="route('news.index')" 
              class="text-gray-300 hover:text-white transition-colors duration-200"
              :class="{ 'text-white': $page.url.startsWith('/news') }">
            Berita
        </Link>

        <Link :href="route('events.index')" 
              class="text-gray-300 hover:text-white transition-colors duration-200"
              :class="{ 'text-white': $page.url.startsWith('/events') }">
            Agenda
        </Link>

        <Link :href="route('galleries.index')" 
              class="text-gray-300 hover:text-white transition-colors duration-200"
              :class="{ 'text-white': $page.url.startsWith('/galleries') }">
            Galeri
        </Link>

        <Link :href="route('contact')" 
              class="text-gray-300 hover:text-white transition-colors duration-200"
              :class="{ 'text-white': $page.url === route('contact') }">
            Kontak
        </Link>
    </div>
</template>

<script setup>
// import jika butuh Link dari Inertia
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
/* Tambahkan styling tambahan jika dibutuhkan */
</style>
