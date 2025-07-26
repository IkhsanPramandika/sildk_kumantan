<template>
    <AdminLayout :title="getCategoryTitle">
        <FormCard :title="getCategoryTitle" :cancel-route="route('admin.village-potentials.index', { category })"
            submit-text="Simpan Potensi" :loading="form.processing" @submit="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField id="title" label="Judul" type="text" v-model="form.title"
                        placeholder="Masukkan judul potensi" required :error="form.errors.title" />
                </div>

                <div class="md:col-span-2">
                    <FormField id="description" label="Deskripsi" type="wysiwyg" v-model="form.description"
                        placeholder="Tulis deskripsi potensi..." :wysiwyg-height="300" required :error="form.errors.description" />
                </div>

                <div class="md:col-span-2">
                    <FileUpload
                        label="Gambar Potensi"
                        :multiple="false"
                        accept="image/*"
                        :show-captions="false"
                        v-model="selectedImage"
                        :error="form.errors.image"
                        help="Pilih gambar untuk potensi (PNG, JPG, atau JPEG, maks. 2MB)"
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
    category: {
        type: String,
        default: 'sda'
    }
})

const getCategoryTitle = computed(() => {
    return props.category === 'sda' ? 'Tambah Sumber Daya Alam' : 'Tambah Infrastruktur'
})

const selectedImage = ref([])

const form = useForm({
    title: '',
    description: '',
    image: null
})

const submit = () => {
    if (selectedImage.value.length > 0) {
        form.image = selectedImage.value[0].file
    }
    form.post(route('admin.village-potentials.store', { category: props.category }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            selectedImage.value = []
        }
    })
}
</script>
