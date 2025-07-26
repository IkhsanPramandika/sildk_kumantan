<template>
    <GuestLayout title="Event">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">Event & Kegiatan</h1>
                    <p class="text-xl text-red-100 opacity-90">
                        Jadwal kegiatan dan acara yang akan berlangsung di desa
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Search and Filter -->
                <div class="max-w-4xl mx-auto mb-12">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1 relative">
                                <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari event..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                />
                            </div>
                            <select
                                v-model="filters.category"
                                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            >
                                <option value="">Semua Kategori</option>
                                <option value="umum">Umum</option>
                                <option value="pemerintahan">Pemerintahan</option>
                                <option value="kegiatan">Kegiatan</option>
                                <option value="pengumuman">Pengumuman</option>
                            </select>
                            <select
                                v-model="filters.status"
                                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            >
                                <option value="">Semua Status</option>
                                <option value="upcoming">Akan Datang</option>
                                <option value="ongoing">Berlangsung</option>
                                <option value="completed">Selesai</option>
                            </select>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            Menampilkan {{ filteredEvents.length }} dari {{ events.length }} event
                        </div>
                    </div>
                </div>

                <!-- Events Grid -->
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <article
                            v-for="event in filteredEvents"
                            :key="event.id"
                            class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group"
                        >
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden">
                                <LazyImage
                                    :src="`/storage/${event.image_url}` || '/placeholder.svg?height=300&width=600&text=Event+Cover'"
                                    :alt="event.title"
                                    height="200px"
                                    imageClass="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <!-- Date Badge -->
                                <div class="absolute top-4 left-4 bg-white rounded-lg p-3 text-center shadow-lg">
                                    <div class="text-xs font-semibold text-gray-600 uppercase">
                                        {{ formatMonth(event.start_date) }}
                                    </div>
                                    <div class="text-xl font-bold text-red-600">
                                        {{ formatDay(event.start_date) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Meta -->
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <div class="flex items-center">
                                        <ClockIcon class="w-4 h-4 mr-1" />
                                        <span>{{ formatTime(event.start_date) }}</span>
                                    </div>
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                        {{ getCategoryText(event.category) }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                    <Link :href="route('events.show', { event: event.slug })">
                                        {{ event.title }}
                                    </Link>
                                </h3>

                                <!-- Description -->
                                <div class="text-gray-600 mb-4 prose prose-sm max-w-none" v-html="truncateDescription(event.description)"></div>

                                <!-- Location -->
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <MapPinIcon class="w-4 h-4 mr-1 flex-shrink-0" />
                                    <span class="truncate">{{ event.location || 'Lokasi akan diumumkan' }}</span>
                                </div>

                                <!-- Action -->
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ formatDate(event.start_date) }}</span>
                                    <Link :href="route('events.show', { event: event.slug })"
                                          class="text-blue-600 hover:text-blue-800 font-medium">
                                        Lihat Detail
                                    </Link>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredEvents.length === 0" class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <CalendarIcon class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada event ditemukan</h3>
                            <p class="text-gray-600 mb-6">
                                {{ searchQuery ? 'Coba ubah kata kunci pencarian Anda' : 'Belum ada event yang dijadwalkan' }}
                            </p>
                            <button
                                v-if="searchQuery || filters.category || filters.status"
                                @click="clearFilters"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                            >
                                Hapus Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <!-- <section class="py-16 bg-red-600">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">Ingin Mengadakan Event?</h2>
                    <p class="text-xl text-red-100 mb-8">
                        Hubungi kami untuk informasi pengajuan kegiatan di desa
                    </p>
                    <Link
                        :href="route('contact')"
                        class="inline-flex items-center px-8 py-4 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors"
                    >
                        Hubungi Kami
                        <ArrowRightIcon class="w-5 h-5 ml-2" />
                    </Link>
                </div>
            </div>
        </section> -->
    </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';
import LazyImage from '@/Components/LazyImage.vue';
import {
    MagnifyingGlassIcon,
    CalendarIcon,
    ClockIcon,
    MapPinIcon,
    ArrowRightIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    events: {
        type: Object,
        required: true
    }
});

const searchQuery = ref('');
const filters = ref({
    category: '',
    status: ''
});

const categories = [
    { id: 'all', name: 'Semua' },
    { id: 'upcoming', name: 'Mendatang' },
    { id: 'past', name: 'Berlalu' }
];

const truncateDescription = (text) => {
    if (!text) return '';
    // Remove HTML tags
    const plainText = text.replace(/<[^>]*>/g, '');
    return plainText.length > 50 ? plainText.substring(0, 50) + '...' : plainText;
};

const filteredEvents = computed(() => {
    let events = props.events.data;

    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        events = events.filter(event =>
            event.title.toLowerCase().includes(query) ||
            event.description.toLowerCase().includes(query) ||
            event.location.toLowerCase().includes(query)
        );
    }

    // Filter by category
    if (filters.value.category) {
        events = events.filter(event => event.category === filters.value.category);
    }

    // Filter by status
    if (filters.value.status) {
        const now = new Date();
        events = events.filter(event => {
            const eventDate = new Date(event.start_date);
            if (filters.value.status === 'upcoming') {
                return eventDate >= now;
            } else if (filters.value.status === 'ongoing') {
                return eventDate < now && eventDate >= new Date(event.end_date);
            } else if (filters.value.status === 'completed') {
                return eventDate < now;
            }
            return true;
        });
    }

    return events;
});

const clearFilters = () => {
    searchQuery.value = '';
    filters.value.category = '';
    filters.value.status = '';
};

const getCategoryText = (category) => {
    const texts = {
        umum: 'Umum',
        pemerintahan: 'Pemerintahan',
        kegiatan: 'Kegiatan',
        pengumuman: 'Pengumuman'
    };
    return texts[category] || category;
};

const formatMonth = (date) => {
    return new Date(date).toLocaleDateString('id-ID', { month: 'short' });
};

const formatDay = (date) => {
    return new Date(date).getDate();
};

const formatTime = (date) => {
    return new Date(date).toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID');
};
</script>
