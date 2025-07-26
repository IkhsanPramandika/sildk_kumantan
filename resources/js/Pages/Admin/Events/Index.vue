<template>
    <AdminLayout title="Kelola Agenda">
        <DataTable title="Event" :data="events" :columns="columns" :filters="filters"
            :create-route="route('admin.events.create')" :show-route="(id) => route('admin.events.show', id)"
            :edit-route="(id) => route('admin.events.edit', id)"
            :delete-route="(id) => route('admin.events.destroy', id)" route-name="admin.events.index">
            <template #cell-featured_image="{ value }">
                <img :src="value ? `/storage/${value}` : '/placeholder.svg?height=50&width=50'"
                    :alt="value ? 'Event image' : 'No image'"
                    class="w-12 h-12 object-cover rounded" />
            </template>

            <template #cell-status="{ value }">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getStatusClass(value)">
                    {{ getStatusText(value) }}
                </span>
            </template>

            <template #cell-event_status="{ value }">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getEventStatusClass(value)">
                    {{ getEventStatusText(value) }}
                </span>
            </template>

            <template #cell-start_date="{ value }">
                {{ formatDate(value) }}
            </template>

            <template #cell-end_date="{ value }">
                {{ formatDate(value) }}
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'

defineProps({
    events: Object,
    filters: Object
})

const columns = [
    { key: 'featured_image', label: 'Gambar' },
    { key: 'title', label: 'Judul' },
    { key: 'category', label: 'Kategori' },
    { key: 'start_date', label: 'Tanggal Mulai' },
    { key: 'end_date', label: 'Tanggal Selesai' },
    { key: 'location', label: 'Lokasi' },
    { key: 'status', label: 'Status Publikasi' },
    { key: 'event_status', label: 'Status Event' }
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
        label: 'Status Publikasi',
        options: [
            { value: 'draft', label: 'Draft' },
            { value: 'published', label: 'Published' },
            { value: 'archived', label: 'Archived' }
        ]
    },
    event_status: {
        label: 'Status Event',
        options: [
            { value: 'upcoming', label: 'Akan Datang' },
            { value: 'ongoing', label: 'Berlangsung' },
            { value: 'completed', label: 'Selesai' },
            { value: 'active', label: 'Aktif (Berlangsung + Akan Datang)' }
        ]
    }
}

const getStatusClass = (status) => {
    const classes = {
        draft: 'bg-gray-100 text-gray-800',
        published: 'bg-green-100 text-green-800',
        archived: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
    const texts = {
        draft: 'Draft',
        published: 'Published',
        archived: 'Archived'
    }
    return texts[status] || status
}

const getEventStatusClass = (status) => {
    const classes = {
        upcoming: 'bg-blue-100 text-blue-800',
        ongoing: 'bg-green-100 text-green-800',
        completed: 'bg-gray-100 text-gray-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getEventStatusText = (status) => {
    const texts = {
        upcoming: 'Akan Datang',
        ongoing: 'Berlangsung',
        completed: 'Selesai'
    }
    return texts[status] || status
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID')
}
</script>
