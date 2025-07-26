<template>
    <AdminLayout :title="getCategoryTitle">
        <FormCard :title="getCategoryTitle" :cancel-route="route('admin.village-potentials.index', { category: potential.category })"
            submit-text="Update Potensi" :loading="form.processing" @submit="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField id="title" label="Judul" type="text" v-model="form.title"
                        placeholder="Masukkan judul potensi" required :error="form.errors.title" />
                </div>

                <div class="md:col-span-2">
                    <FormField id="description" label="Deskripsi" type="wysiwyg" v-model="form.description"
                        placeholder="Tulis deskripsi potensi..." :wysiwyg-height="300" required :error="form.errors.description" />
                </div>

                <!-- Current Image -->
                <div v-if="potential.image" class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</h3>
                    <div class="relative w-full max-w-md">
                        <img :src="`/storage/${potential.image}`"
                            alt="Current image"
                            class="w-full h-auto rounded-lg shadow-sm border border-gray-200" />
                        <button type="button" @click="removeCurrentImage"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                            ×
                        </button>
                    </div>
                </div>

                <!-- New Image -->
                <div class="md:col-span-2">
                    <FileUpload
                        label="Ganti Gambar"
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImage"
                        :error="form.errors.image"
                        help="Pilih gambar baru untuk potensi (PNG, JPG, atau JPEG, maks. 2MB)"
                    />
                </div>
            </div>
        </FormCard>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import FormCard from '@/Components/Admin/FormCard.vue'
import FormField from '@/Components/FormField.vue'
import FileUpload from '@/Components/FileUpload.vue'

const props = defineProps({
    potential: Object
})

const getCategoryTitle = computed(() => {
    return props.potential.category === 'sda' ? 'Edit Sumber Daya Alam' : 'Edit Infrastruktur'
})

const selectedImage = ref([])
const hasRemovedImage = ref(false)

const form = useForm({
    title: props.potential.title,
    description: props.potential.description,
    image: null
})

const removeCurrentImage = () => {
    hasRemovedImage.value = true
    form.image = null
}

const submit = () => {
    if (selectedImage.value.length > 0) {
        form.image = selectedImage.value[0].file
    }
    form.post(route('admin.village-potentials.update', props.potential.id), {
        _method: 'put',
        preserveScroll: true,
        onSuccess: () => {
            form.reset('image')
            selectedImage.value = []
        }
    })
}
</script>
