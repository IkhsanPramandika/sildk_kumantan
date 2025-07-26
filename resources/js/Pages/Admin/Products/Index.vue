<template>
    <AdminLayout title="Kelola Produk UMKM">
        <DataTable title="Produk UMKM" :data="products" :columns="columns" :filters="filters"
            :create-route="route('admin.products.create')" :show-route="(id) => route('admin.products.show', id)"
            :edit-route="(id) => route('admin.products.edit', id)"
            :delete-route="(id) => route('admin.products.destroy', id)">
            <template #cell-image_url="{ value }">
                <img :src="value ? `/storage/${value}` : '/placeholder.svg?height=50&width=50'"
                    :alt="value ? 'Potential image' : 'No image'"
                    class="w-12 h-12 object-cover rounded" />
            </template>

            <template #cell-price="{ value }">
                Rp {{ formatPrice(value) }}
            </template>

            <template #cell-status="{ value }">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getStatusClass(value)">
                    {{ getStatusText(value) }}
                </span>
            </template>

            <template #cell-owner_info="{ item }">
                <div class="space-y-1">
                    <div class="font-medium">{{ item.owner_name }}</div>
                    <div class="text-sm text-gray-500">
                        <a :href="'https://wa.me/' + item.owner_phone" target="_blank" class="text-green-600 hover:text-green-800">
                            {{ item.owner_phone }}
                        </a>
                    </div>
                </div>
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'

defineProps({
    products: Object
})

const columns = [
    { key: 'image_url', label: 'Gambar' },
    { key: 'name', label: 'Nama Produk' },
    { key: 'category', label: 'Kategori' },
    { key: 'price', label: 'Harga' },
    { key: 'owner_info', label: 'Informasi Penjual' },
    { key: 'status', label: 'Status' }
]

const filters = {
    category: {
        label: 'Kategori',
        options: [
            { value: 'food', label: 'Makanan' },
            { value: 'craft', label: 'Kerajinan' },
            { value: 'agriculture', label: 'Pertanian' },
            { value: 'fashion', label: 'Fashion' },
            { value: 'other', label: 'Lainnya' }
        ]
    },
    status: {
        label: 'Status',
        options: [
            { value: 'draft', label: 'Draft' },
            { value: 'published', label: 'Dipublikasi' }
        ]
    }
}

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID').format(price)
}

const getStatusClass = (status) => {
    const classes = {
        draft: 'bg-gray-100 text-gray-800',
        published: 'bg-green-100 text-green-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
    const texts = {
        draft: 'Draft',
        published: 'Dipublikasi'
    }
    return texts[status] || status
}
</script>
