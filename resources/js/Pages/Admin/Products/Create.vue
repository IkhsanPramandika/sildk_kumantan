<template>
    <AdminLayout title="Tambah Produk UMKM">
        <FormCard title="Tambah Produk UMKM Baru" :cancel-route="route('admin.products.index')"
            submit-text="Simpan Produk" :loading="form.processing" @submit="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField id="name" label="Nama Produk" type="text" v-model="form.name"
                        placeholder="Masukkan nama produk" required :error="form.errors.name" />
                </div>

                <FormField id="category" label="Kategori" type="select" v-model="form.category"
                    placeholder="Pilih kategori" required :options="categoryOptions" :error="form.errors.category" />

                <FormField id="status" label="Status" type="select" v-model="form.status" placeholder="Pilih status"
                    required :options="statusOptions" :error="form.errors.status" />

                <FormField id="price" label="Harga (Rp)" type="number" v-model="form.price"
                    placeholder="Masukkan harga produk" required :error="form.errors.price" />

                <!-- Owner Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Pemilik Produk</h3>
                </div>

                <FormField id="owner_name" label="Nama Pemilik" type="text" v-model="form.owner_name"
                    placeholder="Masukkan nama pemilik produk" required :error="form.errors.owner_name" />

                <FormField id="owner_phone" label="Nomor WhatsApp" type="text" v-model="form.owner_phone"
                    placeholder="Contoh: 08123456789" required :error="form.errors.owner_phone" />

                <div class="md:col-span-2">
                    <FormField id="owner_address" label="Alamat Pemilik" type="textarea" v-model="form.owner_address"
                        placeholder="Masukkan alamat lengkap pemilik..." :rows="3" :error="form.errors.owner_address" />
                </div>

                <div class="md:col-span-2">
                    <FormField id="description" label="Deskripsi Produk" type="textarea" v-model="form.description"
                        placeholder="Tulis deskripsi produk di sini..." :rows="6" required
                        :error="form.errors.description" />
                </div>

                <div class="md:col-span-2">
                    <FileUpload
                        label="Gambar Produk"
                        required
                        :multiple="true"
                        accept="image/*"
                        :show-captions="true"
                        v-model="selectedImages"
                        v-model:captions-value="imageCaptions"
                        :error="form.errors.images"
                        help="Pilih beberapa gambar untuk produk"
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

const categoryOptions = [
    { value: 'food', label: 'Makanan' },
    { value: 'craft', label: 'Kerajinan' },
    { value: 'agriculture', label: 'Pertanian' },
    { value: 'fashion', label: 'Fashion' },
    { value: 'other', label: 'Lainnya' }
]

const statusOptions = [
    { value: 'draft', label: 'Draft' },
    { value: 'published', label: 'Dipublikasi' }
]

const form = useForm({
    name: '',
    description: '',
    price: '',
    category: '',
    status: 'draft',
    owner_name: '',
    owner_phone: '',
    owner_address: '',
    images: [],
    captions: []
})

const submit = () => {
    // Prepare images data for submission
    const imagesData = selectedImages.value.map((img, index) => ({
        image: img.file,
        caption: imageCaptions.value[index] || ''
    }))

    form.images = imagesData
    form.post(route('admin.products.store'))
}
</script>
