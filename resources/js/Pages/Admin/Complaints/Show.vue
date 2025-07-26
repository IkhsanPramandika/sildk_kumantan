<template>
    <AdminLayout title="Detail Pengaduan">
        <div class="space-y-6">
            <!-- Complaint Details -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Detail Pengaduan</h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Pengaduan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ complaint.complaint_number }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul</label>
                                <p class="mt-1 text-sm text-gray-900">{{ complaint.title }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <p class="mt-1 text-sm text-gray-900">{{ getCategoryText(complaint.category) }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusClass(complaint.status)">
                                    {{ getStatusText(complaint.status) }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pelapor</label>
                                <p class="mt-1 text-sm text-gray-900">{{ complaint.resident?.full_name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIK</label>
                                <p class="mt-1 text-sm text-gray-900">{{ complaint.resident?.nik }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Lapor</label>
                                <p class="mt-1 text-sm text-gray-900">{{ formatDate(complaint.created_at) }}</p>
                            </div>

                            <div v-if="complaint.response_date">
                                <label class="block text-sm font-medium text-gray-700">Tanggal Respon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ formatDate(complaint.response_date) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi Pengaduan</label>
                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ complaint.description }}</div>
                    </div>

                    <div v-if="complaint.response" class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Respon</label>
                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ complaint.response }}</div>
                    </div>
                </div>
            </div>

            <!-- Response Form -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Berikan Respon</h3>
                </div>

                <form @submit.prevent="submitResponse" class="p-6 space-y-6">
                    <FormField id="status" label="Status" type="select" v-model="form.status" placeholder="Pilih status"
                        required :options="statusOptions" :error="form.errors.status" />

                    <FormField id="response" label="Respon" type="textarea" v-model="form.response"
                        placeholder="Tulis respon untuk pengaduan ini..." :rows="6" required
                        :error="form.errors.response" />

                    <div class="flex justify-end space-x-4">
                        <Link :href="route('admin.complaints.index')"
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        Kembali
                        </Link>
                        <button type="submit" :disabled="form.processing"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50">
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan Respon</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import FormField from '@/Components/FormField.vue'

const props = defineProps({
    complaint: Object
})

const form = useForm({
    status: props.complaint.status,
    response: props.complaint.response || ''
})

const statusOptions = [
    { value: 'pending', label: 'Menunggu' },
    { value: 'received', label: 'Diterima' },
    { value: 'in_progress', label: 'Diproses' },
    { value: 'completed', label: 'Selesai' },
    { value: 'rejected', label: 'Ditolak' }
]

const submitResponse = () => {
    form.post(route('admin.complaints.respond', props.complaint.id), {
        onSuccess: () => {
            router.visit(route('admin.complaints.index'))
        }
    })
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

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>
