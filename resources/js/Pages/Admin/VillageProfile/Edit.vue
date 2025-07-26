<template>
    <AdminLayout title="Edit Profil Desa">
        <FormCard
            title="Edit Profil Desa"
            :cancel-route="route('admin.village-profile.edit')"
            submit-text="Simpan"
            :loading="form.processing"
            @submit="submit"
        >
            <div class="grid grid-cols-1 gap-6">
                <div class="md:col-span-2">
                    <FileUpload
                        label="Struktur Organisasi"
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImages"
                        :error="form.errors.organization_structure_image"
                        help="Pilih gambar struktur organisasi (PNG, JPG, atau JPEG, maks. 2MB)"
                    />
                </div>

                <!-- Current Image Preview -->
                <div v-if="villageProfile.organization_structure_image" class="mt-4 md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</h3>
                    <div class="relative w-full max-w-md">
                        <img
                            :src="`/storage/${villageProfile.organization_structure_image}`"
                            alt="Struktur Organisasi"
                            class="w-full h-auto rounded-lg shadow-sm border border-gray-200"
                        />
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
import FileUpload from '@/Components/FileUpload.vue';

const props = defineProps({
    villageProfile: {
        type: Object,
        required: true
    }
});

const selectedImages = ref([]);

const form = useForm({
    organization_structure_image: null
});

const submit = () => {
    // For single image upload
    if (selectedImages.value.length > 0) {
        form.organization_structure_image = selectedImages.value[0].file;
    }

    form.post(route('admin.village-profile.update', props.villageProfile.id), {
        _method: 'put',
        preserveScroll: true,
        onSuccess: () => {
            form.reset('organization_structure_image');
            selectedImages.value = [];
        }
    });
};
</script>
