<template>
    <div v-if="isOpen"
        class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-80 z-50 flex items-center justify-center">
        <button @click="close" class="absolute top-4 right-4 text-white text-4xl focus:outline-none">&times;</button>
        <div class="flex items-center justify-center w-full">
            <button v-if="images.length > 1" @click="prevImage"
                class="text-white text-4xl px-4 hover:text-gray-300">&lt;</button>
            <div class="flex flex-col items-center">
                <LazyImage :src="currentImage.url" :alt="currentImage.caption || 'Lightbox Image'"
                    imageClass="max-w-full max-h-[80vh] object-contain" />
                <p v-if="currentImage.caption" class="text-white text-center mt-2">{{ currentImage.caption }}</p>
                <p v-if="images.length > 1" class="text-white text-xs mt-1">Gambar {{ currentIndex + 1 }} dari {{
                    images.length }}</p>
            </div>
            <button v-if="images.length > 1" @click="nextImage"
                class="text-white text-4xl px-4 hover:text-gray-300">&gt;</button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import LazyImage from '@/Components/LazyImage.vue'

const isOpen = ref(false)
const images = ref([])
const currentIndex = ref(0)

function open(arg1, arg2) {
    if (Array.isArray(arg1)) {
        images.value = arg1
        currentIndex.value = arg2 || 0
    } else {
        images.value = [{ url: arg1, caption: arg2 }]
        currentIndex.value = 0
    }
    isOpen.value = true
}

function close() {
    isOpen.value = false
}

const currentImage = computed(() => images.value[currentIndex.value] || {})

function nextImage() {
    if (images.value.length > 1) {
        currentIndex.value = (currentIndex.value + 1) % images.value.length
    }
}
function prevImage() {
    if (images.value.length > 1) {
        currentIndex.value = (currentIndex.value - 1 + images.value.length) % images.value.length
    }
}

defineExpose({ open, close })
</script>
