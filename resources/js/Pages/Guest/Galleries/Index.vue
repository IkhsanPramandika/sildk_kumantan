<template>
    <GuestLayout title="Galeri Foto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">
                        Galeri Foto
                    </h1>
                    <p class="text-xl text-purple-100 opacity-90">
                        Dokumentasi visual kegiatan dan perkembangan desa
                    </p>
                </div>
            </div>
        </div>

        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="gallery in galleries.data"
                        :key="gallery.id"
                        class="rounded-lg overflow-hidden cursor-pointer"
                        @click="openImageLightbox(gallery, 0)"
                    >
                        <LazyImage
                            :src="gallery.image_url"
                            :alt="gallery.title"
                            imageClass="w-full h-48 object-cover"
                        />
                        <div class="p-4">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-2"
                            >
                                {{ gallery.title }}
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-3">
                                {{ gallery.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    v-if="galleries.data.length === 0"
                    class="text-center py-16"
                >
                    <div class="max-w-md mx-auto">
                        <PhotoIcon
                            class="w-16 h-16 text-gray-300 mx-auto mb-4"
                        />
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Belum ada galeri
                        </h3>
                        <p class="text-gray-600">Galeri akan segera diisi</p>
                    </div>
                </div>
            </div>
        </section>

        <Lightbox ref="lightbox" />
    </GuestLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import LazyImage from "@/Components/LazyImage.vue";
import Lightbox from "@/Components/Lightbox.vue";
import { PhotoIcon, MagnifyingGlassIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    galleries: {
        type: Object,
        required: true,
    },
});

const lightbox = ref(null);
const openImageLightbox = (gallery, index = 0) => {
    // **PERBAIKAN UTAMA DI SINI: Panggil `img.url`**
    const images = (gallery.images || []).map((img) => ({
        url: img.url, // Memanggil properti 'url' dari objek gambar yang sudah di-serialize oleh Inertia
        caption: img.caption,
    }));
    console.log(images);

    lightbox.value.open(images, index);
};
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
