<template>
<div class="min-h-screen bg-white">
    <Head :title="showSiteName && title !== 'Beranda' ? `${title} - Desa Kumantan` : title" />
    <nav class="bg-white shadow-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <Link :href="'/'" class="flex items-center">
                         <img src="/images/logo-desa.png" alt="Logo Desa" class="h-12 w-12" />
                    </Link>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <Link :href="'/'"
                                :class="[
                                    'px-3 py-2 text-sm font-medium transition-colors relative',
                                    isActiveRoute('/') ? 'text-red-600' : 'text-gray-700 hover:text-red-600'
                                ]">
                        Beranda
                        <span v-if="isActiveRoute('/')" class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600"></span>
                    </Link>

                    <div class="relative">
                        <button @click="toggleProfilDropdown" :class="[
                            'px-3 py-2 text-sm font-medium transition-colors flex items-center relative',
                            isActiveProfilDesa() ? 'text-red-600' : 'text-gray-700 hover:text-red-600'
                        ]">
                            Profil Desa
                            <ChevronDownIcon class="ml-1 h-4 w-4" />
                            <span v-if="isActiveProfilDesa()" class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600"></span>
                        </button>
                        <div v-show="showProfilDropdown" @click.stop class="absolute top-full left-0 mt-1 w-64 bg-white rounded-md shadow-lg border z-50">
                            <Link :href="'/profil-desa/demografi'"
                                        :class="[
                                            'block px-4 py-2 text-sm hover:bg-gray-50',
                                            isActiveRoute('/profil-desa/demografi') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                        ]" @click="closeAllDropdowns">
                                Demografi Penduduk
                            </Link>

                            <!-- Button Navbar untuk Sejarah & Wilayah Desa -->
                            <!-- <Link :href="'/profil-desa/sejarah-desa'"
                                        :class="[
                                            'block px-4 py-2 text-sm hover:bg-gray-50',
                                            isActiveRoute('/profil-desa/sejarah-desa') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                        ]" @click="closeAllDropdowns">
                                Sejarah & Wilayah Desa
                            </Link> -->

                            <div class="relative group">
                                <button class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-red-600">
                                    Potensi Desa
                                    <ChevronRightIcon class="h-4 w-4" />
                                </button>
                                <div class="absolute left-full top-0 mt-0 w-48 bg-white rounded-md shadow-lg border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <Link :href="'/potensi-desa/sumber-daya-alam'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoute('/potensi-desa/sumber-daya-alam') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        Sumber Daya Alam
                                    </Link>
                                    <Link :href="'/potensi-desa/infrastruktur'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoute('/potensi-desa/infrastruktur') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        Infrastruktur
                                    </Link>
                                    <Link :href="'/potensi-desa/umkm'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoutePattern('/potensi-desa/umkm') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        UMKM Desa
                                    </Link>
                                </div>
                            </div>

                            <div class="relative group">
                                <button class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-red-600">
                                    Kelembagaan
                                    <ChevronRightIcon class="h-4 w-4" />
                                </button>
                                <div class="absolute left-full top-0 mt-0 w-48 bg-white rounded-md shadow-lg border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <Link :href="'/profil-desa/sejarah-desa'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoute('/profil-desa/sejarah-desa') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        Sejarah Desa
                                    </Link>
                                    <Link :href="'/profil-desa/struktur-organisasi'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoute('/profil-desa/struktur-organisasi') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        Struktur Organisasi
                                    </Link>
                                    <Link :href="'/kelembagaan/bpd'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoute('/kelembagaan/bpd') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        BPD
                                    </Link>
                                    <Link :href="'/kelembagaan/karang-taruna'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoute('/kelembagaan/karang-taruna') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        Karang Taruna
                                    </Link>
                                    <Link :href="'/kelembagaan/pkk'"
                                                :class="[
                                                    'block px-4 py-2 text-sm hover:bg-gray-50',
                                                    isActiveRoute('/kelembagaan/pkk') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                                ]" @click="closeAllDropdowns">
                                        PKK
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button @click="toggleBeritaDropdown" :class="[
                            'px-3 py-2 text-sm font-medium transition-colors flex items-center relative',
                            isActiveBeritaPengumuman() ? 'text-red-600' : 'text-gray-700 hover:text-red-600'
                        ]">
                            Berita & Pengumuman
                            <ChevronDownIcon class="ml-1 h-4 w-4" />
                            <span v-if="isActiveBeritaPengumuman()" class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600"></span>
                        </button>
                        <div v-show="showBeritaDropdown" @click.stop class="absolute top-full left-0 mt-1 w-48 bg-white rounded-md shadow-lg border z-50">
                            <Link :href="'/berita'"
                                        :class="[
                                            'block px-4 py-2 text-sm hover:bg-gray-50',
                                            isActiveRoutePattern('/berita') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                        ]" @click="closeAllDropdowns">
                                Berita
                            </Link>
                            <Link :href="'/kegiatan'"
                                        :class="[
                                            'block px-4 py-2 text-sm hover:bg-gray-50',
                                            isActiveRoutePattern('/kegiatan') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                        ]" @click="closeAllDropdowns">
                                Agenda Kegiatan
                            </Link>
                        </div>
                    </div>

                    <Link :href="'/galeri'"
                                :class="[
                                    'px-3 py-2 text-sm font-medium transition-colors relative',
                                    isActiveRoutePattern('/galeri') ? 'text-red-600' : 'text-gray-700 hover:text-red-600'
                                ]">
                        Galeri Desa
                        <span v-if="isActiveRoutePattern('/galeri')" class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600"></span>
                    </Link>

                    <a href="https://gis.dukcapil.kemendagri.go.id/peta"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="px-3 py-2 text-sm font-medium transition-colors relative text-gray-700 hover:text-red-600">
                        Peta Wilayah
                    </a>

                    <div class="relative">
                        <button @click="togglePengaduanDropdown" :class="[
                            'px-3 py-2 text-sm font-medium transition-colors flex items-center relative',
                            isActivePengaduan() ? 'text-red-600' : 'text-gray-700 hover:text-red-600'
                        ]">
                            Pengaduan
                            <ChevronDownIcon class="ml-1 h-4 w-4" />
                            <span v-if="isActivePengaduan()" class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600"></span>
                        </button>
                        <div v-show="showPengaduanDropdown" @click.stop class="absolute top-full left-0 mt-1 w-48 bg-white rounded-md shadow-lg border z-50">
                            <Link :href="'/pengaduan/buat'"
                                        :class="[
                                            'block px-4 py-2 text-sm hover:bg-gray-50',
                                            isActiveRoute('/pengaduan/buat') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                        ]" @click="closeAllDropdowns">
                                Buat Pengaduan
                            </Link>
                            <Link :href="'/pengaduan/cek'"
                                        :class="[
                                            'block px-4 py-2 text-sm hover:bg-gray-50',
                                            isActiveRoute('/pengaduan/cek') ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600'
                                        ]" @click="closeAllDropdowns">
                                Cek Status Pengaduan
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="flex items-center" v-if="!$page.props.auth.user">
                    <Link :href="'/login'"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Login Admin
                    </Link>
                </div>

                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-red-600">
                        <Bars3Icon v-if="!mobileMenuOpen" class="h-6 w-6" />
                        <XMarkIcon v-else class="h-6 w-6" />
                    </button>
                </div>
            </div>

            <div v-show="mobileMenuOpen" class="md:hidden border-t border-gray-200 py-4">
                <div class="space-y-2">
                    <Link :href="'/'"
                                :class="[
                                    'block px-3 py-2 text-sm font-medium border-l-4 transition-colors',
                                    isActiveRoute('/') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                        Beranda
                    </Link>

                    <div class="space-y-1">
                        <div class="px-3 py-2 text-sm font-medium text-gray-900 bg-gray-50">Profil Desa</div>
                        <Link :href="'/profil-desa/demografi'"
                                :class="[
                                    'block px-6 py-2 text-sm border-l-4 transition-colors',
                                    isActiveRoute('/profil-desa/demografi') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                            Demografi Penduduk
                        </Link>
                        <Link :href="'/profil-desa/sejarah-desa'"
                                :class="[
                                    'block px-6 py-2 text-sm border-l-4 transition-colors',
                                    isActiveRoute('/profil-desa/sejarah-desa') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                            Sejarah & Wilayah Desa
                        </Link>
                        <Link :href="'/potensi-desa/sumber-daya-alam'"
                                :class="[
                                    'block px-6 py-2 text-sm border-l-4 transition-colors',
                                    isActiveRoutePattern('/potensi-desa') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                            Potensi Desa
                        </Link>
                        <Link :href="'/profil-desa/struktur-organisasi'"
                                :class="[
                                    'block px-6 py-2 text-sm border-l-4 transition-colors',
                                    isActiveRoute('/profil-desa/struktur-organisasi') || isActiveRoutePattern('/kelembagaan') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                            Kelembagaan
                        </Link>
                    </div>

                    <Link :href="'/berita'"
                                :class="[
                                    'block px-3 py-2 text-sm font-medium border-l-4 transition-colors',
                                    isActiveRoutePattern('/berita') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                        Berita
                    </Link>
                    <Link :href="'/kegiatan'"
                                :class="[
                                    'block px-3 py-2 text-sm font-medium border-l-4 transition-colors',
                                    isActiveRoutePattern('/kegiatan') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                        Agenda Kegiatan
                    </Link>
                    <Link :href="'/galeri'"
                                :class="[
                                    'block px-3 py-2 text-sm font-medium border-l-4 transition-colors',
                                    isActiveRoutePattern('/galeri') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                        Galeri Desa
                    </Link>
                    <a href="https://gis.dukcapil.kemendagri.go.id/peta"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block px-3 py-2 text-sm font-medium border-l-4 transition-colors text-gray-700 hover:text-red-600 border-transparent hover:border-red-300">
                        Peta Wilayah
                    </a>
                    <div class="space-y-1">
                        <div class="px-3 py-2 text-sm font-medium text-gray-900 bg-gray-50">Pengaduan</div>
                        <Link :href="'/pengaduan/buat'"
                                :class="[
                                    'block px-6 py-2 text-sm border-l-4 transition-colors',
                                    isActiveRoute('/pengaduan/buat') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                            Buat Pengaduan
                        </Link>
                        <Link :href="'/pengaduan/cek'"
                                :class="[
                                    'block px-6 py-2 text-sm border-l-4 transition-colors',
                                    isActiveRoute('/pengaduan/cek') ? 'text-red-600 border-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 border-transparent hover:border-red-300'
                                ]" @click="mobileMenuOpen = false">
                            Cek Status Pengaduan
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div v-if="showBreadcrumb" class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <Link :href="'/'" class="text-gray-500 hover:text-red-600">
                            Beranda
                        </Link>
                    </li>
                    <li v-for="(crumb, index) in breadcrumbs" :key="index" class="flex items-center">
                        <ChevronRightIcon class="h-4 w-4 text-gray-400 mx-2" />
                        <Link v-if="crumb.url && index < breadcrumbs.length - 1"
                                :href="crumb.url"
                                class="text-gray-500 hover:text-red-600">
                            {{ crumb.title }}
                        </Link>
                        <span v-else class="text-gray-900 font-medium">
                            {{ crumb.title }}
                        </span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="mb-4" v-if="$page.props.sessionStatus">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <div class="font-medium text-sm text-green-600">
                    {{ $page.props.sessionStatus }}
                </div>
            </div>
        </div>
    </div>

    <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="mb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                <div class="font-medium text-red-600 mb-2">
                    Whoops! Something went wrong.
                </div>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                    <li v-for="(error, key) in $page.props.errors" :key="key">
                        {{ error }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <main>
        <slot />
    </main>

    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="/images/logo-desa.png" alt="Logo Desa" class="h-24 mr-3" />
                        <div>
                            <h3 class="text-lg font-semibold">Desa Kumantan</h3>
                            <p class="text-gray-600">Kecamatan Kumantan, Kabupaten Bengkalis</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">
                        Mewujudkan desa yang maju, mandiri, dan sejahtera melalui pemanfaatan teknologi digital dan pemberdayaan masyarakat.
                    </p>
                    <div class="space-y-2 text-sm text-gray-300">
                        <div class="flex items-center">
                            <MapPinIcon class="w-4 h-4 mr-2" />
                            <span>Jl. Lintas Sumatera, Desa Kumantan, Kec. XIII Koto Kampar, Kab. Kampar, Riau 28463</span>
                        </div>
                        <div class="flex items-center">
                            <PhoneIcon class="w-4 h-4 mr-2" />
                            <span>(0761) 123-4567</span>
                        </div>
                        <div class="flex items-center">
                            <EnvelopeIcon class="w-4 h-4 mr-2" />
                            <span>info@desakumantan.id</span>
                        </div>
                        <div class="flex items-center">
                            <GlobeAltIcon class="w-4 h-4 mr-2" />
                            <span>www.desakumantan.id</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Menu Utama</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><Link :href="'/'" class="hover:text-white transition-colors">Beranda</Link></li>
                        <li><Link :href="'/profil-desa/sejarah-desa'" class="hover:text-white transition-colors">Profil Desa</Link></li>
                        <li><Link :href="'/profil-desa/demografi'" class="hover:text-white transition-colors">Demografi</Link></li>
                        <li><Link :href="'/berita'" class="hover:text-white transition-colors">Berita</Link></li>
                        <li><Link :href="'/kegiatan'" class="hover:text-white transition-colors">Agenda</Link></li>
                        <li><Link :href="'/galeri'" class="hover:text-white transition-colors">Galeri</Link></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><Link :href="'/pengaduan/buat'" class="hover:text-white transition-colors">Pengaduan Online</Link></li>
                        <li><Link :href="'/pengaduan/cek'" class="hover:text-white transition-colors">Cek Status Pengaduan</Link></li>
                        <li><a href="https://gis.dukcapil.kemendagri.go.id/peta" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">Peta Wilayah</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400 mb-4 md:mb-0">
                        <p>© {{ new Date().getFullYear() }} Desa Kumantan. All rights reserved.</p>
                    </div>
                    <div class="flex space-x-6 text-sm text-gray-400">
                        <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                        <a href="#" class="hover:text-white transition-colors">Kontak</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    ChevronDownIcon,
    ChevronRightIcon,
    Bars3Icon,
    XMarkIcon,
    MapPinIcon,
    PhoneIcon,
    EnvelopeIcon,
    GlobeAltIcon,
} from '@heroicons/vue/24/outline';
import LazyImage from '@/Components/LazyImage.vue'
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        default: 'Desa Kumantan'
    },
    showSiteName: {
        type: Boolean,
        default: true
    }
});

const page = usePage();

const showProfilDropdown = ref(false);
const showBeritaDropdown = ref(false);
const showPengaduanDropdown = ref(false);
const mobileMenuOpen = ref(false);

// Helper functions for active route detection
const isActiveRoute = (path) => {
    return window.location.pathname === path;
};

const isActiveRoutePattern = (pattern) => {
    return window.location.pathname.startsWith(pattern);
};

const isActiveProfilDesa = () => {
    return (
        isActiveRoutePattern('/profil-desa') ||
        isActiveRoutePattern('/potensi-desa') ||
        isActiveRoutePattern('/kelembagaan')
    );
};

const isActiveBeritaPengumuman = () => {
    return (
        isActiveRoutePattern('/berita') ||
        isActiveRoutePattern('/pengumuman') ||
        isActiveRoutePattern('/kegiatan')
    );
};

const isActivePengaduan = () => {
    return isActiveRoutePattern('/pengaduan');
};

// Dropdown toggle functions
const toggleProfilDropdown = () => {
    showProfilDropdown.value = !showProfilDropdown.value;
    // Close other dropdowns when one is opened
    showBeritaDropdown.value = false;
    showPengaduanDropdown.value = false;
};

const toggleBeritaDropdown = () => {
    showBeritaDropdown.value = !showBeritaDropdown.value;
    // Close other dropdowns when one is opened
    showProfilDropdown.value = false;
    showPengaduanDropdown.value = false;
};

const togglePengaduanDropdown = () => {
    showPengaduanDropdown.value = !showPengaduanDropdown.value;
    // Close other dropdowns when one is opened
    showProfilDropdown.value = false;
    showBeritaDropdown.value = false;
};

const closeAllDropdowns = () => {
    showProfilDropdown.value = false;
    showBeritaDropdown.value = false;
    showPengaduanDropdown.value = false;
};

// Close dropdowns when clicking outside
const handleClickOutside = (event) => {
    if (!event.target.closest('.relative')) { // Check if the click is outside any dropdown container
        closeAllDropdowns();
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

// Breadcrumb logic
const showBreadcrumb = computed(() => {
    return window.location.pathname !== '/';
});

const breadcrumbs = computed(() => {
    const path = window.location.pathname;
    const crumbs = [];

    // Profile routes
    if (path === '/profil-desa/sejarah-desa') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'Sejarah Desa' });
    } else if (path === '/profil-desa/struktur-organisasi') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'Struktur Organisasi' });
    } else if (path === '/profil-desa/wilayah') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'Wilayah Desa' });
    } else if (path === '/profil-desa/demografi') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'Demografi Penduduk' });
    }

    // Potentials routes
    else if (path === '/potensi-desa/sumber-daya-alam') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'Sumber Daya Alam' });
    } else if (path === '/potensi-desa/infrastruktur') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'Infrastruktur' });
    } else if (path === '/potensi-desa/umkm') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'UMKM Desa' });
    } else if (path.startsWith('/potensi-desa/umkm/')) {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'UMKM Desa', url: '/potensi-desa/umkm' });
        crumbs.push({ title: 'Detail Produk' });
    }

    // Organizations routes
    else if (path === '/kelembagaan/bpd') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'BPD' });
    } else if (path === '/kelembagaan/karang-taruna') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'Karang Taruna' });
    } else if (path === '/kelembagaan/pkk') {
        crumbs.push({ title: 'Profil Desa', url: '/profil-desa/sejarah-desa' });
        crumbs.push({ title: 'PKK' });
    }

    // News routes
    else if (path === '/berita') {
        crumbs.push({ title: 'Berita' });
    } else if (path.startsWith('/berita/')) {
        crumbs.push({ title: 'Berita', url: '/berita' });
        crumbs.push({ title: 'Detail Berita' });
    }

    // Announcement routes
    else if (path === '/pengumuman') {
        crumbs.push({ title: 'Pengumuman' });
    } else if (path.startsWith('/pengumuman/')) {
        crumbs.push({ title: 'Pengumuman', url: '/pengumuman' });
        crumbs.push({ title: 'Detail Pengumuman' });
    }

    // Event routes
    else if (path === '/kegiatan') {
        crumbs.push({ title: 'Agenda Kegiatan' });
    } else if (path.startsWith('/kegiatan/')) {
        crumbs.push({ title: 'Agenda Kegiatan', url: '/kegiatan' });
        crumbs.push({ title: 'Detail Agenda' });
    }

    // Gallery routes
    else if (path === '/galeri') {
        crumbs.push({ title: 'Galeri Desa' });
    } else if (path.startsWith('/galeri/')) {
        crumbs.push({ title: 'Galeri Desa', url: '/galeri' });
        crumbs.push({ title: 'Detail Galeri' });
    }

    // Complaint routes
    else if (path === '/pengaduan/buat') {
        crumbs.push({ title: 'Buat Pengaduan' });
    } else if (path === '/pengaduan/cek') {
        crumbs.push({ title: 'Cek Status Pengaduan' });
    } else if (path.startsWith('/pengaduan/status/')) {
        crumbs.push({ title: 'Cek Status Pengaduan', url: '/pengaduan/cek' });
        crumbs.push({ title: 'Detail Pengaduan' });
    } else if (path === '/pengaduan/sukses') {
        crumbs.push({ title: 'Cek Status Pengaduan', url: '/pengaduan/cek' });
        crumbs.push({ title: 'Pengaduan Berhasil' });
    }

    // Map route
    else if (path === '/peta-wilayah') {
        crumbs.push({ title: 'Peta Wilayah' });
    }

    // Contact route
    else if (path === '/kontak') {
        crumbs.push({ title: 'Kontak' });
    }

    return crumbs;
});
</script>
