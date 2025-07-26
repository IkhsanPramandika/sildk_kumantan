<template>
    <AdminLayout title="Edit Produk UMKM">
        <FormCard title="Edit Produk UMKM" :cancel-route="route('admin.products.index')" submit-text="Update Produk"
            :loading="form.processing" @submit="submit">
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

                <FormField id="stock" label="Stok" type="number" v-model="form.stock" placeholder="Masukkan jumlah stok"
                    required :error="form.errors.stock" />

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

                <!-- Existing Images -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Produk Saat Ini
                    </label>
                    <div v-if="existingImages.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(image, index) in existingImages" :key="image.id"
                            class="border border-gray-300 rounded-md p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium">Gambar {{ index + 1 }}</h4>
                                <button type="button" @click="removeExistingImage(index)"
                                    class="text-red-600 hover:text-red-800">
                                    Hapus
                                </button>
                            </div>

                            <div>
                                <LazyImage
                                    :src="image.image_url || '/placeholder.svg?height=150&width=150'"
                                    alt="Product image"
                                    imageClass="h-32 object-contain mb-2"
                                />
                                <input type="text" v-model="existingImages[index].caption"
                                    placeholder="Caption gambar (opsional)"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                            </div>
                        </div>
                    </div>
                    <p v-else class="text-sm text-gray-500">Tidak ada gambar produk</p>
                </div>

                <!-- New Images -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tambah Gambar Baru
                    </label>
                    <div class="space-y-4">
                        <div v-for="(image, index) in newImages" :key="index"
                            class="border border-gray-300 rounded-md p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium">Gambar Baru {{ index + 1 }}</h4>
                                <button type="button" @click="removeNewImage(index)"
                                    class="text-red-600 hover:text-red-800">
                                    Hapus
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <input type="file" accept="image/*" @change="(e) => handleNewImageChange(e, index)"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, maksimal 2MB</p>
                                </div>

                                <div>
                                    <input type="text" v-model="newImages[index].caption"
                                        placeholder="Caption gambar (opsional)"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                </div>
                            </div>

                            <div v-if="newImages[index].preview" class="mt-2">
                                <LazyImage
                                    :src="newImages[index].preview"
                                    alt="Preview"
                                    imageClass="h-32 object-contain"
                                />
                            </div>
                        </div>

                        <button type="button" @click="addNewImage"
                            class="flex items-center text-blue-600 hover:text-blue-800">
                            <PlusIcon class="w-5 h-5 mr-1" />
                            Tambah Gambar Baru
                        </button>
                    </div>
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
import { PlusIcon } from '@heroicons/vue/24/outline'
import LazyImage from '@/Components/LazyImage.vue'


const props = defineProps({
    product: Object,
})

const existingImages = ref(props.product.images.map(image => ({
    id: image.id,
    image_url: image.image_url,
    caption: image.caption
})))

const newImages = ref([])

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    category: props.product.category,
    status: props.product.status,
    owner_name: props.product.owner_name,
    owner_phone: props.product.owner_phone,
    owner_address: props.product.owner_address,
    images: [],
    deleted_images: []
})

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

const addNewImage = () => {
    newImages.value.push({ image: null, caption: '', preview: null })
}

const removeNewImage = (index) => {
    newImages.value.splice(index, 1)
}

const removeExistingImage = (index) => {
    const imageToRemove = existingImages.value[index]
    form.deleted_images.push(imageToRemove.id)
    existingImages.value.splice(index, 1)
}

const handleNewImageChange = (event, index) => {
    const file = event.target.files[0]
    if (file) {
        newImages.value[index].image = file

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
            newImages.value[index].preview = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const submit = () => {
    // Prepare existing images data
    form.images = existingImages.value.map(item => ({
        id: item.id,
        caption: item.caption,
        order: item.order
    }))

    // Add new images
    newImages.value
        .filter(item => item.image)
        .forEach(item => {
            form.images.push({
                image: item.image,
                caption: item.caption
            })
        })

    form.post(route('admin.products.update', props.product.id))
}
</script>
