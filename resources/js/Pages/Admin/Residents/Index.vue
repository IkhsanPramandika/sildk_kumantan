<template>
    <AdminLayout title="Data Penduduk">
        <DataTable
            title="Data Penduduk"
            :data="props.residents"
            :columns="columns"
            :filters="filters"
            :create-route="route('admin.residents.create')"
            :show-route="(id) => route('admin.residents.show', id)"
            :edit-route="(id) => route('admin.residents.edit', id)"
            :delete-route="(id) => route('admin.residents.destroy', id)"
            :route-name="route().current()"
            :import-enabled="true"
            @import="showImportModal = true"
        >
            <template #cell-gender="{ value }">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="value === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'"
                >
                    {{ value === 'male' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </template>

            <template #cell-life_status="{ value }">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="value === 'alive' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                >
                    {{ value === 'alive' ? 'Hidup' : 'Meninggal' }}
                </span>
            </template>

            <template #cell-birth_date="{ value }">
                {{ formatDate(value) }}
            </template>
        </DataTable>
        <ImportModal :show="showImportModal" @close="showImportModal = false" />
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'
import { ref } from 'vue'
import ImportModal from '@/Components/ImportModal.vue'

const showImportModal = ref(false)

const props = defineProps({
    residents: {
        type: Object,
        required: true
    }
})

const columns = [
    { key: 'nik', label: 'NIK' },
    { key: 'full_name', label: 'Nama Lengkap', sortable: true }, 
    { key: 'gender', label: 'Jenis Kelamin' },
    { key: 'birth_date', label: 'Tanggal Lahir' },
    { key: 'rt', label: 'RT' },
    { key: 'rw', label: 'RW' },
    { key: 'occupation', label: 'Pekerjaan' },
    { key: 'life_status', label: 'Status Hidup' }
]

const filters = {
    sort_name: {
        label: 'Urutkan Nama',
        options: [
            { value: 'asc', label: 'A-Z (Ascending)' },
            { value: 'desc', label: 'Z-A (Descending)' }
        ]
    },
    gender: {
        label: 'Jenis Kelamin',
        options: [
            { value: 'male', label: 'Laki-laki' },
            { value: 'female', label: 'Perempuan' }
        ]
    },
    life_status: {
        label: 'Status Hidup',
        options: [
            { value: 'alive', label: 'Hidup' },
            { value: 'deceased', label: 'Meninggal' }
        ]
    },
    occupation: {
        label: 'Pekerjaan',
        options: [
        { value: 'MENGURUS RUMAH TANGGA', label: 'IRT' },
        { value: 'WIRASWASTA', label: 'Wiraswasta' },
        { value: 'PEGAWAI NEGERI SIPIL', label: 'PNS' },
        { value: 'PELAJAR/MAHASISWA', label: 'Pelajar/Mahasiswa' },
        { value: 'PETANI/PEKEBUN', label: 'Petani/Kebun' },
        { value: 'BELUM/TIDAK BEKERJA', label: 'Tidak Bekerja' }
    ]
    },
    rt: {
        label: 'RT',
        options: Array.from({ length: 20 }, (_, i) => ({
            value: (i + 1).toString(),
            label: 'RT ' + (i + 1)
        }))
    },
    rw: {
        label: 'RW',
        options: Array.from({ length: 20 }, (_, i) => ({
            value: (i + 1).toString(),
            label: 'RW ' + (i + 1)
        }))

    },
    
}

const formatDate = (date) => {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    })
}
</script>