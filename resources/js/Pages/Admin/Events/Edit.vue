<template>
    <AdminLayout title="Edit Event">
        <FormCard
            title="Edit Event"
            :cancel-route="route('admin.events.index')"
            submit-text="Simpan"
            :loading="form.processing"
            @submit="submit"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField
                        id="title"
                        label="Judul Event"
                        type="text"
                        v-model="form.title"
                        placeholder="Masukkan judul event"
                        required
                        :error="form.errors.title"
                    />
                </div>

                <FormField
                    id="category"
                    label="Kategori"
                    type="select"
                    v-model="form.category"
                    placeholder="Pilih kategori"
                    required
                    :options="categoryOptions"
                    :error="form.errors.category"
                />

                <FormField
                    id="status"
                    label="Status"
                    type="select"
                    v-model="form.status"
                    placeholder="Pilih status"
                    required
                    :options="statusOptions"
                    :error="form.errors.status"
                />

                <FormField
                    id="start_date"
                    label="Tanggal Mulai"
                    type="date"
                    v-model="form.start_date"
                    required
                    :error="form.errors.start_date"
                />

                <FormField
                    id="end_date"
                    label="Tanggal Selesai"
                    type="date"
                    v-model="form.end_date"
                    required
                    :error="form.errors.end_date"
                />

                <div class="md:col-span-2">
                    <FormField
                        id="location"
                        label="Lokasi"
                        type="text"
                        v-model="form.location"
                        placeholder="Masukkan lokasi event"
                        required
                        :error="form.errors.location"
                    />
                </div>

                <div class="md:col-span-2">
                    <FormField
                        id="description"
                        label="Deskripsi Event"
                        type="wysiwyg"
                        v-model="form.description"
                        placeholder="Tulis deskripsi event di sini..."
                        :wysiwyg-height="400"
                        required
                        :error="form.errors.description"
                        help="Gunakan editor untuk membuat deskripsi event yang menarik dan informatif"
                    />
                </div>

                <div class="md:col-span-2">
                    <FileUpload
                        label="Gambar Utama Event"
                        required
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImage"
                        :error="form.errors.featured_image"
                        help="Pilih gambar utama untuk event (PNG, JPG, JPEG, maks. 2MB)"
                    />
                </div>

                <!-- Current Image Preview -->
                <div v-if="event.featured_image" class="mt-4 md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</h3>
                    <div class="relative w-full max-w-md">
                        <img
                            :src="event.featured_image"
                            alt="Gambar Utama Event"
                            class="w-full h-auto rounded-lg shadow-sm border border-gray-200"
                        />
                    </div>
                </div>
            </div>
        </FormCard>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FormCard from '@/Components/Admin/FormCard.vue';
import FormField from '@/Components/FormField.vue';
import FileUpload from '@/Components/FileUpload.vue';

const props = defineProps({
    event: {
        type: Object,
        required: true
    }
});

const selectedImage = ref([]);

onMounted(() => {
    if (props.event.featured_image) {
        selectedImage.value = [{
            preview: '/storage/' + props.event.featured_image,
            file: null
        }];
    }
});

const form = useForm({
    title: props.event.title || '',
    description: props.event.description || '',
    category: props.event.category || '',
    status: props.event.status || 'draft',
    start_date: props.event.start_date || '',
    end_date: props.event.end_date || '',
    location: props.event.location || '',
    featured_image: null
});

const categoryOptions = [
    { value: 'umum', label: 'Umum' },
    { value: 'pemerintahan', label: 'Pemerintahan' },
    { value: 'kegiatan', label: 'Kegiatan' },
    { value: 'pengumuman', label: 'Pengumuman' }
];

const statusOptions = [
    { value: 'draft', label: 'Draft' },
    { value: 'published', label: 'Published' },
    { value: 'archived', label: 'Archived' }
];

const submit = () => {
    if (selectedImage.value.length > 0 && selectedImage.value[0].file) {
        form.featured_image = selectedImage.value[0].file;
    }
    form.post(route('admin.events.update', props.event.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('featured_image');
            selectedImage.value = [];
        }
    });
};
</script>
