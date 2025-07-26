<template>
    <AdminLayout title="Edit Galeri">
        <FormCard title="Edit Galeri" :cancel-route="route('admin.galleries.index')" submit-text="Update Galeri"
            :loading="form.processing" @submit="submit">
            <div class="space-y-6">
                <FormField id="title" label="Judul Galeri" type="text" v-model="form.title"
                    placeholder="Masukkan judul galeri" required :error="form.errors.title" />

                <FormField id="description" label="Deskripsi" type="textarea" v-model="form.description"
                    placeholder="Tulis deskripsi galeri..." :rows="4" :error="form.errors.description" />

                <div class="flex items-center">
                    <input id="is_published" type="checkbox" v-model="form.is_published"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                        Publikasikan galeri
                    </label>
                </div>

                <!-- Existing Images -->
                <div v-if="gallery.images && gallery.images.length > 0" class="space-y-4">
                    <h4 class="text-sm font-medium text-gray-700">Gambar Saat Ini</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div v-for="(image, index) in existingImages" :key="image.id" class="relative">
                            <LazyImage
                                :src="image.url || '/placeholder.svg?height=150&width=150'"
                                :alt="`Image ${index + 1}`"
                                imageClass="w-full h-24 object-cover rounded-lg"
                            />
                            <button type="button" @click="removeExistingImage(index)"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                ×
                            </button>
                            <div class="mt-2">
                                <input type="text" v-model="image.caption" placeholder="Caption (opsional)"
                                    class="w-full text-xs px-2 py-1 border border-gray-300 rounded" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tambah Gambar Baru
                    </label>
                    <input type="file" multiple accept="image/*" @change="handleFileChange"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        :class="{ 'border-red-500': form.errors.new_images }" />
                    <p v-if="form.errors.new_images" class="text-sm text-red-600 mt-1">{{ form.errors.new_images }}</p>
                    <p class="text-sm text-gray-500 mt-1">Pilih beberapa gambar untuk ditambahkan ke galeri</p>
                </div>

                <!-- New Image Preview -->
                <div v-if="selectedImages.length > 0" class="space-y-4">
                    <h4 class="text-sm font-medium text-gray-700">Preview Gambar Baru</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div v-for="(image, index) in selectedImages" :key="index" class="relative">
                            <LazyImage
                                :src="image.preview"
                                :alt="`Preview ${index + 1}`"
                                imageClass="w-full h-24 object-cover rounded-lg"
                            />
                            <button type="button" @click="removeImage(index)"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                ×
                            </button>
                            <div class="mt-2">
                                <input type="text" v-model="image.caption" placeholder="Caption (opsional)"
                                    class="w-full text-xs px-2 py-1 border border-gray-300 rounded" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </FormCard>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import FormCard from '@/Components/Admin/FormCard.vue'
import FormField from '@/Components/FormField.vue'
import LazyImage from '@/Components/LazyImage.vue'


const props = defineProps({
    gallery: Object
})

const existingImages = ref([])
const selectedImages = ref([])

const form = useForm({
    title: props.gallery.title,
    description: props.gallery.description,
    is_published: props.gallery.is_published,
    existing_images: [],
    new_images: [],
    new_captions: []
})

onMounted(() => {
    existingImages.value = props.gallery.images.map(image => ({
        id: image.id,
        url: image.image_path,
        caption: image.caption
    }))
    form.existing_images = existingImages.value
})


const handleFileChange = (event) => {
    const files = Array.from(event.target.files)
    selectedImages.value = []

    files.forEach((file, index) => {
        const reader = new FileReader()
        reader.onload = (e) => {
            selectedImages.value.push({
                file: file,
                preview: e.target.result,
                caption: ''
            })
        }
        reader.readAsDataURL(file)
    })
}

const removeImage = (index) => {
    selectedImages.value.splice(index, 1)
}

const removeExistingImage = (index) => {
    existingImages.value.splice(index, 1)
    form.existing_images = existingImages.value
}

const submit = () => {
    // Update existing images data
    form.existing_images = existingImages.value

    // Add new images data
    form.new_images = selectedImages.value.map(img => img.file)
    form.new_captions = selectedImages.value.map(img => img.caption)

    form.post(route('admin.galleries.update', props.gallery.id))
}
</script>
