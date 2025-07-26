<template>
    <AdminLayout title="Kelola Galeri">
        <DataTable title="Galeri" :data="galleries" :columns="columns" :filters="filters"
            :create-route="route('admin.galleries.create')" :show-route="(id) => route('admin.galleries.show', id)"
            :edit-route="(id) => route('admin.galleries.edit', id)"
            :delete-route="(id) => route('admin.galleries.destroy', id)">
            <template #cell-image_url="{ value }">
                <img :src="value ? `/storage/${value}` : '/placeholder.svg?height=50&width=50'"
                    :alt="value ? 'Galeri image' : 'No image'"
                    class="w-12 h-12 object-cover rounded" />
            </template>

            <template #cell-is_published="{ value }">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="value ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                    {{ value ? 'Dipublikasi' : 'Draft' }}
                </span>
            </template>

            <template #cell-images_count="{ item }">
                {{ item.image_count || 0 }} foto
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'

defineProps({
    galleries: Object
})

const columns = [
    { key: 'image_url', label: 'Gambar' },
    { key: 'title', label: 'Judul' },
    { key: 'description', label: 'Deskripsi' },
    { key: 'images_count', label: 'Jumlah Foto' },
    { key: 'is_published', label: 'Status' }
]

const filters = {
    is_published: {
        label: 'Status',
        options: [
            { value: '1', label: 'Dipublikasi' },
            { value: '0', label: 'Draft' }
        ]
    }
}
</script>
