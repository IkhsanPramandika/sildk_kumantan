<template>
    <AdminLayout title="Tambah Galeri">
        <FormCard title="Tambah Galeri Baru" :cancel-route="route('admin.galleries.index')" submit-text="Simpan Galeri"
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

                <FileUpload
                    label="Gambar Galeri"
                    required
                    :multiple="true"
                    accept="image/*"
                    :show-captions="true"
                    v-model="selectedImages"
                    v-model:captions-value="imageCaptions"
                    :error="form.errors.images"
                    help="Pilih beberapa gambar untuk galeri"
                />
            </div>
        </FormCard>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import FormCard from '@/Components/Admin/FormCard.vue'
import FormField from '@/Components/FormField.vue'
import FileUpload from '@/Components/FileUpload.vue'


const selectedImages = ref([])
const imageCaptions = ref([])

const form = useForm({
    title: '',
    description: '',
    is_published: false,
    images: [],
    captions: []
})

const submit = () => {
    form.images = selectedImages.value.map(img => img.file)
    form.captions = imageCaptions.value
    form.post(route('admin.galleries.store'))
}
</script>
