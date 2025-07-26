<template>
    <div class="relative w-full" :style="componentHeightStyle">
        <PlaceholderImage v-if="!isLoaded && !hasError" />
        <div
            v-if="hasError"
            class="absolute inset-0 flex items-center justify-center rounded-lg bg-gray-300 text-gray-500 text-sm"
        >
            <svg class="w-1/3 h-1/3 max-w-12 max-h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="ml-2">Gambar Gagal Dimuat</span>
        </div>

        <img
            :src="src"
            :alt="alt"
            :class="[imageClass, { 'opacity-0': !isLoaded || hasError, 'opacity-100': isLoaded && !hasError }]"
            :style="{ objectFit: objectFit }"
            class="w-full h-full rounded-lg transition-opacity duration-300"
            @load="handleLoad"
            @error="handleError"
        />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import PlaceholderImage from './PlaceholderImage.vue';

const props = defineProps({
    src: {
        type: String,
        required: true
    },
    alt: {
        type: String,
        default: ''
    },
    aspectRatio: {
        type: String,
        default: 'auto'
    },
    imageClass: {
        type: String,
        default: ''
    },
    objectFit: {
        type: String,
        default: 'cover',
        validator: (value) => ['cover', 'contain', 'fill', 'none', 'scale-down'].includes(value)
    }
});

const isLoaded = ref(false);
const hasError = ref(false);

// Handles successful image load
const handleLoad = () => {
    isLoaded.value = true;
    hasError.value = false;
};

// Handles image load error
const handleError = () => {
    isLoaded.value = true; // Still mark as loaded to hide the initial pulse, but show error placeholder
    hasError.value = true;
    console.error(`Failed to load image: ${props.src}`); // Ini akan log URL yang gagal
};

// --- Computed properties for height and aspect ratio ---
const componentHeightStyle = computed(() => {
    if (props.aspectRatio !== 'auto') {
        // Calculate padding-top for aspect ratio trick
        const [width, height] = props.aspectRatio.split('/').map(Number);
        if (width && height) {
            return {
                paddingTop: `${(height / width) * 100}%`,
                height: '0', // Important to collapse height so padding-top dictates it
                position: 'relative' // Ensure relative for absolute children
            };
        }
    }
    // Fallback to direct height if aspectRatio is 'auto' or invalid
    return {
        height: props.height
    };
});
</script>