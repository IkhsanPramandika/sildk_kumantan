<template>
    <AdminLayout title="Edit Berita">
        <FormCard
            title="Edit Berita"
            :cancel-route="route('admin.news.index')"
            submit-text="Simpan"
            :loading="form.processing"
            @submit="submit"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField
                        id="title"
                        label="Judul Berita"
                        type="text"
                        v-model="form.title"
                        placeholder="Masukkan judul berita"
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
                    id="publish_date"
                    label="Tanggal Publikasi"
                    type="date"
                    v-model="form.publish_date"
                    required
                    :error="form.errors.publish_date"
                />

                <div class="md:col-span-2">
                    <FormField
                        id="content"
                        label="Konten Berita"
                        type="wysiwyg"
                        v-model="form.content"
                        placeholder="Tulis konten berita di sini..."
                        :wysiwyg-height="500"
                        required
                        :error="form.errors.content"
                        help="Gunakan editor untuk memformat teks, menambahkan gambar, dan membuat konten yang menarik"
                    />
                </div>

                <div class="md:col-span-2">
                    <FileUpload
                        label="Gambar Utama Berita"
                        :required="false"
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImage"
                        :error="form.errors.featured_image"
                        help="Pilih gambar utama untuk berita (PNG, JPG, JPEG, maks. 2MB). Kosongkan jika tidak ingin mengubah gambar."
                    />
                    <!-- Button to clear newly selected image -->
                    <button
                        v-if="selectedImage.length > 0"
                        @click="clearSelectedImage"
                        class="mt-2 text-sm text-red-600 hover:text-red-800"
                    >
                        Batalkan pilihan gambar baru
                    </button>
                </div>

                <!-- Current Image Preview -->
                <div v-if="existingImage || selectedImage.length > 0" class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">
                        {{ selectedImage.length > 0 ? 'Pratinjau Gambar Baru' : 'Gambar Saat Ini' }}
                    </h3>
                    <div class="relative w-full max-w-md">
                        <LazyImage
                            :src="selectedImage.length > 0 ? selectedImage[0].preview : existingImage"
                            alt="Gambar Utama Berita"
                            imageClass="w-full h-auto rounded-lg shadow-sm border border-gray-200"
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
import LazyImage from '@/Components/LazyImage.vue';
import { format } from 'date-fns';

const props = defineProps({
    news: {
        type: Object,
        required: true
    }
});

const selectedImage = ref([]); // For newly selected image
const existingImage = ref(null); // For the existing image from props.news

// Helper function to format date for input
const formatDateForInput = (dateString) => {
    if (!dateString) return new Date().toISOString().split('T')[0];

    try {
        const date = new Date(dateString);
        return date.toISOString().split('T')[0];
    } catch (error) {
        return new Date().toISOString().split('T')[0];
    }
};

// Initialize form with existing data
const form = useForm({
    title: props.news.title || '',
    content: props.news.content || '',
    category: props.news.category || '',
    status: props.news.status || 'draft',
    publish_date: formatDateForInput(props.news.publish_date),
    featured_image: null
});

onMounted(() => {
    // Initialize existing image
    if (props.news.featured_image) {
        existingImage.value = '/storage/' + props.news.featured_image;
    }
});

// Clear selected image and revert to existing image
const clearSelectedImage = () => {
    selectedImage.value = [];
};

const categoryOptions = [
    { value: 'umum', label: 'Umum' },
    { value: 'pemerintahan', label: 'Pemerintahan' },
    { value: 'kegiatan', label: 'Kegiatan' },
    { value: 'pengumuman', label: 'Pengumuman' }
];

const statusOptions = [
    { value: 'draft', label: 'Draft' },
    { value: 'published', label: 'Dipublikasi' },
    { value: 'archived', label: 'Diarsipkan' }
];

const submit = () => {
    // Only set featured_image if a new file is selected
    if (selectedImage.value.length > 0 && selectedImage.value[0].file) {
        form.featured_image = selectedImage.value[0].file;
    } else {
        form.featured_image = null; // Ensure no new file is sent if only previewing existing
    }

    form.post(route('admin.news.update', props.news.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            // Reset the file input
            form.reset('featured_image');
            // Update existingImage with the new image URL from the server response (if available)
            if (page.props.news && page.props.news.featured_image) {
                existingImage.value = page.props.news.featured_image;
            }
            // Clear selected image
            selectedImage.value = [];
        },
        onError: (errors) => {
            console.error('Form submission errors:', errors);
        }
    });
};
</script>
