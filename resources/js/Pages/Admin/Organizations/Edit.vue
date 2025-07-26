<template>
    <AdminLayout :title="typeLabel">
        <FormCard
            :title="typeLabel"
            :cancel-route="route('admin.dashboard')"
            submit-text="Simpan"
            :loading="form.processing"
            @submit="submit"
        >
            <div class="space-y-6">
                <div>
                    <FormField
                        id="title"
                        label="Judul"
                        type="text"
                        v-model="form.title"
                        placeholder="Masukkan judul organisasi"
                        required
                        :error="form.errors.title"
                    />
                </div>

                <div>
                    <FormField
                        id="description"
                        label="Deskripsi"
                        type="wysiwyg"
                        v-model="form.description"
                        placeholder="Tulis deskripsi organisasi..."
                        :wysiwyg-height="400"
                        required
                        :error="form.errors.description"
                    />
                </div>

                <div>
                    <FileUpload
                        label="Gambar Struktur Organisasi"
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImages"
                        :error="form.errors.structure_image"
                        help="Pilih gambar struktur organisasi (PNG, JPG, atau JPEG, maks. 2MB)"
                    />

                    <!-- Current Image Preview -->
                    <div v-if="organization?.structure_image" class="mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</h3>
                        <div class="relative w-full max-w-2xl">
                            <LazyImage
                                :src="'/storage/' + organization.structure_image"
                                alt="Struktur Organisasi"
                                imageClass="w-full h-auto rounded-lg shadow-sm border border-gray-200"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </FormCard>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FormCard from '@/Components/Admin/FormCard.vue';
import FormField from '@/Components/FormField.vue';
import FileUpload from '@/Components/FileUpload.vue';
import LazyImage from '@/Components/LazyImage.vue';

const props = defineProps({
    organization: {
        type: Object,
        required: true
    },
    type: {
        type: String,
        required: true
    },
    typeLabel: {
        type: String,
        required: true
    }
});

const selectedImages = ref([]);

const form = useForm({
    title: props.organization.title,
    description: props.organization.description,
    structure_image: null
});

const submit = () => {
    if (selectedImages.value.length > 0) {
        form.structure_image = selectedImages.value[0].file;
    }

    form.post(route('admin.organizations.update', props.type), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('structure_image');
            selectedImages.value = [];
        },
    });
};
</script>
