<template>
    <AdminLayout title="Tambah Berita">
        <FormCard title="Tambah Berita Baru" :cancel-route="route('admin.news.index')" submit-text="Simpan Berita"
            :loading="form.processing" @submit="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField id="title" label="Judul Berita" type="text" v-model="form.title"
                        placeholder="Masukkan judul berita" required :error="form.errors.title" />
                </div>

                <FormField id="category" label="Kategori" type="select" v-model="form.category"
                    placeholder="Pilih kategori" required :options="categoryOptions" :error="form.errors.category" />

                <FormField id="status" label="Status" type="select" v-model="form.status" placeholder="Pilih status"
                    required :options="statusOptions" :error="form.errors.status" />

                <FormField id="publish_date" label="Tanggal Publikasi" type="date" v-model="form.publish_date" required
                    :error="form.errors.publish_date" />

                <div class="md:col-span-2">
                    <FormField id="content" label="Konten Berita" type="wysiwyg" v-model="form.content"
                        placeholder="Tulis konten berita di sini..." :wysiwyg-height="500" required :error="form.errors.content"
                        help="Gunakan editor untuk memformat teks, menambahkan gambar, dan membuat konten yang menarik" />
                </div>

                <div class="md:col-span-2">
                    <FileUpload
                        label="Gambar Berita"
                        required
                        :multiple="true"
                        accept="image/*"
                        :show-captions="true"
                        v-model="selectedImages"
                        v-model:captions-value="imageCaptions"
                        :error="form.errors.images"
                        help="Pilih satu atau lebih gambar untuk berita"
                    />
                </div>
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
    content: '',
    category: '',
    status: 'draft',
    publish_date: new Date().toISOString().split('T')[0],
    featured_image: null
})

const categoryOptions = [
    { value: 'umum', label: 'Umum' },
    { value: 'pemerintahan', label: 'Pemerintahan' },
    { value: 'kegiatan', label: 'Kegiatan' },
    { value: 'pengumuman', label: 'Pengumuman' }
]

const statusOptions = [
    { value: 'draft', label: 'Draft' },
    { value: 'published', label: 'Dipublikasi' },
    { value: 'archived', label: 'Diarsipkan' }
]

const submit = () => {
    form.featured_image = selectedImages.value[0].file
    form.post(route('admin.news.store'))
}
</script>
