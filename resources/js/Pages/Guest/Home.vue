<template>
    <GuestLayout title="Beranda">
        <Hero :images="images" />

        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 border-b-2 border-red-600 pb-2 inline-block">
                        STATISTIK</h2>
                    <p class="text-gray-600 mt-1">STATISTIK DESA</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div>
                        <div class="text-4xl font-bold text-gray-900 mb-1">
                            <AnimatedNumber :value="stats.total_male" :duration="1000" />
                        </div>
                        <div class="text-lg text-gray-600">Laki-laki</div>
                    </div>

                    <div>
                        <div class="text-4xl font-bold text-gray-900 mb-1">
                            <AnimatedNumber :value="stats.total_female" :duration="1000" />
                        </div>
                        <div class="text-lg text-gray-600">Perempuan</div>
                    </div>

                    <Link :href="route('profile.history')" class="block hover:text-red-600 transition-colors">
                    <div>
                        <div class="text-xl font-semibold text-gray-700 mb-1">Data Wilayah</div>
                        <div class="text-gray-500 text-sm">Lihat detail peta dan data wilayah</div>
                    </div>
                    </Link>

                    <Link :href="route('profile.demographics')" class="block hover:text-red-600 transition-colors">
                    <div>
                        <div class="text-xl font-semibold text-gray-700 mb-1">Data Pendidikan</div>
                        <div class="text-gray-500 text-sm">Lihat data penduduk berdasarkan pendidikan</div>
                    </div>
                    </Link>

                    <div class="col-span-2">
                        <div class="text-xl font-semibold text-gray-800">
                            Total Penduduk: <span class="text-red-600 font-bold">
                                <AnimatedNumber :value="stats.total_residents" :duration="1000" />
                            </span>
                        </div>
                    </div>

                    <Link :href="route('profile.demographics')" class="block hover:text-red-600 transition-colors">
                    <div>
                        <div class="text-xl font-semibold text-gray-700 mb-1">Data Pekerjaan</div>
                        <div class="text-gray-500 text-sm">Lihat data penduduk berdasarkan pekerjaan</div>
                    </div>
                    </Link>

                    <Link :href="route('profile.demographics')" class="block hover:text-red-600 transition-colors">
                    <div>
                        <div class="text-xl font-semibold text-gray-700 mb-1">Data Usia</div>
                        <div class="text-gray-500 text-sm">Lihat data penduduk berdasarkan usia</div>
                    </div>
                    </Link>
                </div>
            </div>
        </section>

        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 border-b-2 border-red-600 pb-2 inline-block">BERITA
                    </h2>
                    <p class="text-gray-600 mt-1">BERITA TERKINI</p>
                </div>

                <div v-if="latestNews && latestNews.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article v-for="(news, index) in latestNews" :key="news.id"
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 overflow-hidden cursor-pointer" @click="openNewsLightbox(index)">
                            <LazyImage
                                :src="`/storage/${news.image_url}` || '/placeholder.svg?height=300&width=600&text=News+Cover'"
                                :alt="news.title" imageClass="w-full h-full object-cover" />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <CalendarIcon class="w-4 h-4 mr-2" />
                                <span>{{ news.publish_date }}</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                <Link :href="route('news.show', { news: news.slug })"
                                    class="hover:text-red-600 transition-colors">
                                {{ news.title }}
                                </Link>
                            </h3>
                            <div class="text-gray-600 mb-4 line-clamp-3 prose prose-sm max-w-none"
                                v-html="news.description"></div>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ formatDate(news.publish_date) }}</span>
                                <Link :href="route('news.show', { news: news.slug })"
                                    class="text-red-600 hover:text-red-800 font-medium">
                                Baca Selengkapnya
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>
                <div v-else class="text-center py-12">
                    <NewspaperIcon class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada berita</h3>
                    <p class="text-gray-500">Berita akan segera hadir</p>
                </div>

                <div class="mt-12 text-center">
                    <Link :href="route('news.index')"
                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    Lihat Semua Berita
                    <ArrowRightIcon class="ml-2 w-4 h-4" />
                    </Link>
                </div>
            </div>
        </section>

        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 border-b-2 border-red-600 pb-2 inline-block">AGENDA
                    </h2>
                    <p class="text-gray-600 mt-1">AGENDA MENDATANG</p>
                </div>

                <div v-if="upcomingEvents && upcomingEvents.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="(event, index) in upcomingEvents" :key="event.id"
                        class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 overflow-hidden cursor-pointer" @click="openEventLightbox(index)">
                            <LazyImage
                                :src="`/storage/${event.image_url}` || '/placeholder.svg?height=300&width=600&text=Event+Cover'"
                                :alt="event.title" imageClass="w-full h-full object-cover" />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <CalendarIcon class="w-4 h-4 mr-2" />
                                <span>{{ event.start_date }}</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                <Link :href="route('events.show', { event: event.slug })"
                                    class="hover:text-red-600 transition-colors">
                                {{ event.title }}
                                </Link>
                            </h3>
                            <div class="text-gray-600 mb-4 line-clamp-2 prose prose-sm max-w-none"
                                v-html="event.description"></div>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ formatDate(event.start_date) }}</span>
                                <Link :href="route('events.show', { event: event.slug })"
                                    class="text-red-600 hover:text-red-800 font-medium">
                                Lihat Detail
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-12">
                    <CalendarIcon class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada agenda mendatang</h3>
                    <p class="text-gray-500">Agenda akan segera diumumkan</p>
                </div>

                <div class="mt-12 text-center">
                    <Link :href="route('events.index')"
                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    Lihat Semua Agenda
                    <ArrowRightIcon class="ml-2 w-4 h-4" />
                    </Link>
                </div>
            </div>
        </section>

        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 border-b-2 border-red-600 pb-2 inline-block">GALERI
                    </h2>
                    <p class="text-gray-600 mt-1">GALERI DESA</p>
                </div>

                <div v-if="latestGalleries && latestGalleries.length > 0"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="(gallery, index) in latestGalleries" :key="gallery.id"
                        class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <div class="cursor-pointer relative" @click="openGalleryLightbox(index)">
                            <LazyImage
                                :src="`/storage/${gallery.image_url}` || gallery.image_url || '/placeholder.svg?height=400&width=600&text=Gallery+Image'"
                                :alt="gallery.title" imageClass="w-full h-80 object-cover" />
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <div
                                    class="bg-white text-gray-800 rounded-full p-3 hover:bg-gray-100 transition-colors">
                                    <MagnifyingGlassIcon class="w-6 h-6" />
                                </div>
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                <h3 class="text-white font-medium text-lg">{{ gallery.title }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-12">
                    <PhotoIcon class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada galeri</h3>
                    <p class="text-gray-500">Galeri akan segera diisi</p>
                </div>

                <div class="mt-12 text-center">
                    <Link :href="route('galleries.index')"
                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    Lihat Semua Galeri
                    <ArrowRightIcon class="ml-2 w-4 h-4" />
                    </Link>
                </div>
            </div>
        </section>

        <Lightbox ref="lightbox" />
    </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Hero from '@/Components/Guest/Hero.vue'
import Lightbox from '@/Components/Lightbox.vue'
import LazyImage from '@/Components/LazyImage.vue'
import AnimatedNumber from '@/Components/AnimatedNumber.vue'
import {
    ArrowRightIcon,
    CalendarIcon,
    MapPinIcon,
    MagnifyingGlassIcon,
    PhotoIcon,
    UsersIcon,
    UserIcon,
    UserGroupIcon,
    NewspaperIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    villageProfile: {
        type: Object,
        default: () => ({})
    },
    stats: {
        type: Object,
        default: () => ({
            total_residents: 4779,
            total_male: 2372,
            total_female: 2407,
            total_news: 0
        })
    },
    latestNews: {
        type: Array,
        default: () => []
    },
    upcomingEvents: {
        type: Array,
        default: () => []
    },
    latestGalleries: {
        type: Array,
        default: () => []
    },
    error: {
        type: String,
        default: null
    }
})

const images = ref([
    {
        url: 'images/hero/hero-1.jpg',
        alt: ''
    },
    {
        url: 'images/hero/hero-2.jpg',
        alt: 'Pura di tepi danau di Bali'
    },
    {
        url: 'images/hero/hero-3.jpg',
        alt: 'Tari tradisional Bali'
    },
    {
        url: 'images/hero/hero-4.jpg',
        alt: 'Pantai tropis di Indonesia'
    }
])

const lightbox = ref(null)
const openNewsLightbox = (index = 0) => {
    const images = props.latestNews.map(news => ({
        url: '/storage/' + news.image_url || '/placeholder.svg?height=300&width=600&text=News+Cover',
        caption: news.title
    }))
    lightbox.value.open(images, index)
}
const openEventLightbox = (index = 0) => {
    const images = props.upcomingEvents.map(event => ({
        url: '/storage/' + event.image_url || '/placeholder.svg?height=300&width=600&text=Event+Cover',
        caption: event.title
    }))
    lightbox.value.open(images, index)
}
const openGalleryLightbox = (index = 0) => {
    const images = props.latestGalleries.map(gallery => ({
        url: '/storage/' + gallery.image_url || '/placeholder.svg?height=400&width=600&text=Gallery+Image',
        caption: gallery.title
    }))
    lightbox.value.open(images, index)
}

function formatDate(date) {
    return new Date(date).toLocaleDateString();
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
