<template>
    <section class="relative h-[70vh] min-h-[500px] overflow-hidden">
        <div class="relative w-full h-full">
            <div
                v-for="(image, index) in images"
                :key="index"
                class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="{ 'opacity-100': currentIndex === index, 'opacity-0': currentIndex !== index }"
            >
                <img
                    :src="image.url"
                    :alt="image.alt"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
                <div class="absolute inset-0 bg-black/50"></div>

                <div class="absolute inset-0 flex items-center justify-center max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-white">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 leading-tight">
                            Selamat Datang di Website Resmi Desa Kumantan
                        </h1>
                        <p class="text-lg sm:text-xl md:text-2xl max-w-3xl mx-auto mb-8 font-light">
                            Bersama kita wujudkan desa yang maju, mandiri, dan sejahtera.
                        </p>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10">
                <button
                    v-for="(image, index) in images"
                    :key="index"
                    @click="goToSlide(index)"
                    class="w-3 h-3 rounded-full transition-all duration-300"
                    :class="{
                        'bg-white': currentIndex === index,
                        'bg-white/50': currentIndex !== index
                    }"
                    :aria-label="`Pergi ke slide ${index + 1}`"
                ></button>
            </div>

            <button
                @click="previousSlide"
                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white p-3 transition-opacity duration-300 z-10 opacity-0 hover:opacity-100 focus:opacity-100"
                aria-label="Slide sebelumnya"
            >
                <ChevronLeftIcon class="w-6 h-6" />
            </button>

            <button
                @click="nextSlide"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white p-3 transition-opacity duration-300 z-10 opacity-0 hover:opacity-100 focus:opacity-100"
                aria-label="Slide berikutnya"
            >
                <ChevronRightIcon class="w-6 h-6" />
            </button>

            <button
                @click="toggleAutoPlay"
                class="absolute top-4 right-4 text-white p-2 transition-opacity duration-300 z-10 opacity-0 hover:opacity-100 focus:opacity-100"
                :aria-label="isPlaying ? 'Jeda tayangan slide' : 'Putar tayangan slide'"
            >
                <PauseIcon v-if="isPlaying" class="w-5 h-5" />
                <PlayIcon v-else class="w-5 h-5" />
            </button>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { ChevronLeftIcon, ChevronRightIcon, PlayIcon, PauseIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    images: {
        type: Array,
        required: true,
        default: () => []
    }
})

const currentIndex = ref(0)
const isPlaying = ref(true)
const interval = 5000 // Nilai interval tetap 5 detik
let slideInterval = null

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % props.images.length
}

const previousSlide = () => {
    currentIndex.value = currentIndex.value === 0 ? props.images.length - 1 : currentIndex.value - 1
}

const goToSlide = (index) => {
    currentIndex.value = index
}

const startAutoPlay = () => {
    if (props.images.length <= 1) return // Jika hanya ada 0 atau 1 gambar, tidak perlu autoplay

    // Hentikan interval yang sedang berjalan sebelum memulai yang baru
    stopAutoPlay();

    slideInterval = setInterval(() => {
        nextSlide()
    }, interval)
    isPlaying.value = true
}

const stopAutoPlay = () => {
    if (slideInterval) {
        clearInterval(slideInterval)
        slideInterval = null
    }
    isPlaying.value = false
}

const toggleAutoPlay = () => {
    if (isPlaying.value) {
        stopAutoPlay()
    } else {
        startAutoPlay()
    }
}

const handleKeydown = (event) => {
    switch (event.key) {
        case 'ArrowLeft':
            previousSlide()
            break
        case 'ArrowRight':
            nextSlide()
            break
        case ' ': // Spasi untuk play/pause
            event.preventDefault()
            toggleAutoPlay()
            break
    }
}

onMounted(() => {
    // Mulai autoplay hanya jika ada lebih dari 1 gambar
    if (props.images.length > 1) {
        startAutoPlay();
    }
    document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    stopAutoPlay()
    document.removeEventListener('keydown', handleKeydown)
})

// Menambahkan watch untuk images prop, berguna jika gambar di-load secara asinkron
watch(() => props.images.length, (newLength, oldLength) => {
    if (newLength > 1 && !isPlaying.value) { // Jika gambar menjadi lebih dari 1 dan tidak sedang bermain
        startAutoPlay();
    } else if (newLength <= 1) { // Jika gambar kembali menjadi 0 atau 1
        stopAutoPlay();
        currentIndex.value = 0; // Reset index
    }
}, { immediate: true }); // Jalankan saat komponen dimuat
</script>
