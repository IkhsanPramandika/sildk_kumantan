<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="relative">
      <LazyImage :src="event.image" :alt="event.title" class="w-full h-48 object-cover"height="200px" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
      <div class="absolute bottom-0 left-0 right-0 p-4">
        <h3 class="text-xl font-semibold text-white mb-2">{{ event.title }}</h3>
        <div class="flex items-center text-white/90 text-sm space-x-4">
          <div class="flex items-center">
            <CalendarIcon class="h-4 w-4 mr-1" />
            <span>{{ formatDate(event.date) }}</span>
          </div>
          <div class="flex items-center">
            <MapPinIcon class="h-4 w-4 mr-1" />
            <span>{{ event.location }}</span>
          </div>
          <div class="flex items-center">
            <ClockIcon class="h-4 w-4 mr-1" />
            <span>{{ event.time }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="p-4">
      <p class="text-gray-600 text-sm mb-4">{{ truncateDescription(event.description) }}</p>
      <div class="flex justify-between items-center">
        <span class="text-sm text-gray-500">{{ formatDate(event.date) }}</span>
        <Link :href="route('events.show', { event: event.slug })" class="text-blue-600 hover:text-blue-800 text-sm">
          Lihat Detail
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { CalendarIcon, MapPinIcon, ClockIcon } from '@heroicons/vue/24/solid';
import LazyImage from '@/Components/LazyImage.vue'

const props = defineProps({
  event: {
    type: Object,
    required: true
  }
});

const formatDate = (date) => {
  if (!date) return '';
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const truncateDescription = (text) => {
  if (!text) return '';
  // Remove HTML tags
  const plainText = text.replace(/<[^>]*>/g, '');
  return plainText.length > 50 ? plainText.substring(0, 50) + '...' : plainText;
};
</script>
