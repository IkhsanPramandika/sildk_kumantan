<template>
    <AdminLayout :title="getCategoryTitle">
        <DataTable :title="getCategoryTitle" :data="potentials" :columns="columns"
            :create-route="route('admin.village-potentials.create', { category })"
            :show-route="(id) => route('admin.village-potentials.show', id)"
            :edit-route="(id) => route('admin.village-potentials.edit', id)"
            :delete-route="(id) => route('admin.village-potentials.destroy', id)">
            <template #cell-image="{ value }">
                <img :src="value ? `/storage/${value}` : '/placeholder.svg?height=50&width=50'"
                    :alt="value ? 'Potential image' : 'No image'"
                    class="w-12 h-12 object-cover rounded" />
            </template>

            <template #cell-category="{ value }">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getCategoryClass(value)">
                    {{ getCategoryText(value) }}
                </span>
            </template>

            <template #cell-description="{ value }">
                <div class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none"
                    v-html="value || '<p>Tidak ada konten.</p>'"></div>
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'
import { computed } from 'vue'

const props = defineProps({
    potentials: Object,
    category: {
        type: String,
        default: 'sda'
    }
})

const getCategoryTitle = computed(() => {
    return props.category === 'sda' ? 'Sumber Daya Alam' : 'Infrastruktur'
})

const columns = [
    { key: 'image', label: 'Gambar' },
    { key: 'title', label: 'Judul' },
    { key: 'description', label: 'Deskripsi' },
]

const getCategoryClass = (category) => {
    const classes = {
        infrastruktur: 'bg-blue-100 text-blue-800',
        sda: 'bg-green-100 text-green-800'
    }
    return classes[category] || 'bg-gray-100 text-gray-800'
}

const getCategoryText = (category) => {
    const texts = {
        in: 'Infrastruktur',
        sda: 'Sumber Daya Alam'
    }
    return texts[category] || category
}
</script>
