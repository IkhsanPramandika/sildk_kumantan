<template>
    <AdminLayout title="Kelola Berita">
        <DataTable title="Berita" :data="news" :columns="columns" :filters="filters"
            :create-route="route('admin.news.create')" :show-route="(id) => route('admin.news.show', id)"
            :edit-route="(id) => route('admin.news.edit', id)" :delete-route="(id) => route('admin.news.destroy', id)">
            <template #cell-featured_image="{ value }" >
                <img :src="value ? `/storage/${value}` : '/placeholder.svg?height=50&width=50'"
                    :alt="value ? 'News image' : 'No image'"
                    class="w-12 h-12 object-cover rounded" />
            </template>

            <template #cell-status="{ value }">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getStatusClass(value)">
                    {{ getStatusText(value) }}
                </span>
            </template>

            <template #cell-publish_date="{ value }">
                {{ formatDate(value) }}
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'

defineProps({
    news: Object
})

const columns = [
    { key: 'featured_image', label: 'Gambar' },
    { key: 'title', label: 'Judul' },
    { key: 'category', label: 'Kategori' },
    { key: 'status', label: 'Status' },
    { key: 'publish_date', label: 'Tanggal Publikasi' }
]

const filters = {
    category: {
        label: 'Kategori',
        options: [
            { value: 'umum', label: 'Umum' },
            { value: 'pemerintahan', label: 'Pemerintahan' },
            { value: 'kegiatan', label: 'Kegiatan' },
            { value: 'pengumuman', label: 'Pengumuman' }
        ]
    },
    status: {
        label: 'Status',
        options: [
            { value: 'draft', label: 'Draft' },
            { value: 'published', label: 'Dipublikasi' },
            { value: 'archived', label: 'Diarsipkan' }
        ]
    }
}

const getStatusClass = (status) => {
    const classes = {
        draft: 'bg-gray-100 text-gray-800',
        published: 'bg-green-100 text-green-800',
        archived: 'bg-yellow-100 text-yellow-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
    const texts = {
        draft: 'Draft',
        published: 'Dipublikasi',
        archived: 'Diarsipkan'
    }
    return texts[status] || status
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID')
}
</script>
