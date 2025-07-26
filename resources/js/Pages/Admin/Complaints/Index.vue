<template>
    <AdminLayout title="Kelola Pengaduan">
        <DataTable title="Pengaduan Masyarakat" :data="complaints" :columns="columns" :filters="filters"
            :show-route="(id) => route('admin.complaints.show', id)">
            <template #cell-status="{ value }">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getStatusClass(value)">
                    {{ getStatusText(value) }}
                </span>
            </template>

            <template #cell-category="{ value }">
                {{ getCategoryText(value) }}
            </template>

            <template #cell-resident="{ item }">
                {{ item.resident?.full_name }}
            </template>

            <template #cell-created_at="{ value }">
                {{ formatDate(value) }}
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'

defineProps({
    complaints: Object
})

const columns = [
    { key: 'complaint_number', label: 'Nomor Pengaduan' },
    { key: 'title', label: 'Judul' },
    { key: 'category', label: 'Kategori' },
    { key: 'resident', label: 'Pelapor' },
    { key: 'status', label: 'Status' },
    { key: 'created_at', label: 'Tanggal Lapor' }
]

const filters = {
    status: {
        label: 'Status',
        options: [
            { value: 'pending', label: 'Menunggu' },
            { value: 'received', label: 'Diterima' },
            { value: 'in_progress', label: 'Diproses' },
            { value: 'completed', label: 'Selesai' },
            { value: 'rejected', label: 'Ditolak' }
        ]
    },
    category: {
        label: 'Kategori',
        options: [
            { value: 'infrastruktur', label: 'Infrastruktur' },
            { value: 'kebersihan', label: 'Kebersihan' },
            { value: 'keamanan', label: 'Keamanan' },
            { value: 'kesehatan', label: 'Kesehatan' },
            { value: 'pendidikan', label: 'Pendidikan' },
            { value: 'sosial', label: 'Sosial' },
            { value: 'lainnya', label: 'Lainnya' }
        ]
    }
}

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        received: 'bg-blue-100 text-blue-800',
        in_progress: 'bg-orange-100 text-orange-800',
        completed: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
    const texts = {
        pending: 'Menunggu',
        received: 'Diterima',
        in_progress: 'Diproses',
        completed: 'Selesai',
        rejected: 'Ditolak'
    }
    return texts[status] || status
}

const getCategoryText = (category) => {
    const texts = {
        infrastruktur: 'Infrastruktur',
        kebersihan: 'Kebersihan',
        keamanan: 'Keamanan',
        kesehatan: 'Kesehatan',
        pendidikan: 'Pendidikan',
        sosial: 'Sosial',
        lainnya: 'Lainnya'
    }
    return texts[category] || category
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID')
}
</script>
