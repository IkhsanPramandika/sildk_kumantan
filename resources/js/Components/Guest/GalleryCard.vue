<template>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        <LazyImage 
            :src="gallery.image_url" 
            :alt="gallery.title"
            imageClass="w-full h-48 object-cover"
        />
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">{{ gallery.title }}</div>
            <p class="text-gray-700 text-base">
                {{ gallery.description }}
            </p>
        </div>
        <div class="px-6 pt-4 pb-2">
            <Link :href="route('galleries.show', gallery.id)" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                View More
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import LazyImage from '@/Components/LazyImage.vue';

const props = defineProps({
    gallery: {
        type: Object,
        required: true,
    }
});
</script>
