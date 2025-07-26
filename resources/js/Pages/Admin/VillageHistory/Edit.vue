<template>
    <AdminLayout title="Edit Sejarah Desa">
        <FormCard
            title="Edit Sejarah Desa"
            :cancel-route="route('admin.village-history.edit')"
            submit-text="Simpan"
            :loading="form.processing"
            @submit="submit"
        >
            <div class="grid grid-cols-1 gap-6">
                <div class="md:col-span-2">
                    <FormField
                        id="village_history"
                        label="Sejarah Desa"
                        type="wysiwyg"
                        v-model="form.village_history"
                        placeholder="Tulis sejarah desa di sini..."
                        :wysiwyg-height="500"
                        required
                        :error="form.errors.village_history"
                        help="Gunakan editor untuk membuat konten sejarah desa yang menarik dan informatif"
                    />
                </div>

                <div class="md:col-span-2">
                    <FileUpload
                        label="Gambar Sejarah Desa"
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImages"
                        :error="form.errors.village_history_image"
                        help="Pilih gambar untuk sejarah desa (PNG, JPG, atau JPEG, maks. 2MB)"
                    />
                </div>

                <!-- Current Image Preview -->
                <div v-if="form.village_history_image" class="mt-4 md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</h3>
                    <div class="relative w-full max-w-md">
                        <img
                            :src="form.village_history_image"
                            alt="Gambar Sejarah Desa"
                            class="w-full h-auto rounded-lg shadow-sm border border-gray-200"
                        />
                    </div>
                </div>
            </div>
        </FormCard>
    </AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FormCard from '@/Components/Admin/FormCard.vue';
import FormField from '@/Components/FormField.vue';
import FileUpload from '@/Components/FileUpload.vue';

const props = defineProps({
    villageProfile: {
        type: Object,
        required: true
    }
});

const selectedImages = ref([]);

const form = useForm({
    village_history: props.villageProfile.village_history || '',
    village_history_image: props.villageProfile.village_history_image || null
});

// Watch for changes in selectedImages and update form.village_history_image
watch(selectedImages, (newImages) => {
    form.village_history_image = newImages.length > 0 ? newImages[0].file : null;
});

const submit = () => {
    form.post(route('admin.village-history.update', props.villageProfile.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('village_history_image');
            selectedImages.value = [];
        }
    });
};
</script>
