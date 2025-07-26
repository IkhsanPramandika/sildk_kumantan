<template>
    <AdminLayout title="Tambah Agenda">
        <FormCard title="Tambah Event Baru" :cancel-route="route('admin.events.index')" submit-text="Simpan Event"
            :loading="form.processing" @submit="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField id="title" label="Judul Event" type="text" v-model="form.title"
                        placeholder="Masukkan judul event" required :error="form.errors.title" />
                </div>

                <FormField id="category" label="Kategori" type="select" v-model="form.category"
                    placeholder="Pilih kategori" required :options="categoryOptions" :error="form.errors.category" />

                <FormField id="status" label="Status" type="select" v-model="form.status" placeholder="Pilih status"
                    required :options="statusOptions" :error="form.errors.status" />

                <FormField id="start_date" label="Tanggal Mulai" type="date" v-model="form.start_date" required
                    :error="form.errors.start_date" />

                <FormField id="end_date" label="Tanggal Selesai" type="date" v-model="form.end_date" required
                    :error="form.errors.end_date" />

                <div class="md:col-span-2">
                    <FormField id="location" label="Lokasi" type="text" v-model="form.location"
                        placeholder="Masukkan lokasi event" required :error="form.errors.location" />
                </div>

                <div class="md:col-span-2">
                    <FormField id="description" label="Deskripsi Event" type="wysiwyg" v-model="form.description"
                        placeholder="Tulis deskripsi event di sini..." :wysiwyg-height="400" required
                        :error="form.errors.description"
                        help="Gunakan editor untuk membuat deskripsi event yang menarik dan informatif" />
                </div>

                <div class="md:col-span-2">
                    <FileUpload
                        label="Gambar Event"
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImages"
                        :error="form.errors.image"
                        help="Pilih gambar untuk event"
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

const form = useForm({
    title: '',
    description: '',
    category: '',
    start_date: '',
    end_date: '',
    location: '',
    status: 'upcoming',
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
    { value: 'published', label: 'Published' },
    { value: 'archived', label: 'Archived' }
]

const submit = () => {
    // For single image upload
    if (selectedImages.value.length > 0) {
        form.featured_image = selectedImages.value[0].file
    }

    form.post(route('admin.events.store'))
}
</script>
