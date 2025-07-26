<template>
  <div class="max-w-sm rounded overflow-hidden shadow-lg">
    <LazyImage 
      :src="news.image_url" 
      alt="News Image"
      imageClass="w-full h-48 object-cover"
    />
    <div class="px-6 py-4">
      <div class="font-bold text-xl mb-2">{{ news.title }}</div>
      <p class="text-gray-700 text-base">
        {{ news.description }}
      </p>
    </div>
    <div class="px-6 pt-4 pb-2">
      <Link :href="route('news.show', news.slug)" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
        View More
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import LazyImage from '@/Components/LazyImage.vue';

const props = defineProps({
  news: {
    type: Object,
    required: true
  }
});
</script>
