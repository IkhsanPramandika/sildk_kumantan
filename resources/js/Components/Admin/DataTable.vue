<template>
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="relative" v-if="searchable">
                        <input v-model="searchQuery" type="text" placeholder="Cari..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        <MagnifyingGlassIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
                    </div>

                    <!-- Create Button -->
                    <Link v-if="createRoute" :href="createRoute"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <PlusIcon class="w-5 h-5 inline mr-2" />
                    Tambah {{ title }}
                    </Link>
                    <!-- Import Button -->
                    <button v-if="importEnabled" @click="$emit('import')"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                        <ArrowUpTrayIcon class="w-5 h-5 mr-2" />
                        Import Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div v-if="filters && Object.keys(filters).length > 0" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-wrap gap-4">
                <div v-for="(filter, key) in filters" :key="key" class="flex flex-col">
                    <label class="text-sm font-medium text-gray-700 mb-1">{{ filter.label }}</label>
                    <select v-model="filterValues[key]"
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua</option>
                        <option v-for="option in filter.options" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th v-for="column in columns" :key="column.key"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ column.label }}
                        </th>
                        <th v-if="showRoute || editRoute || deleteRoute"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="item in data.data" :key="item.id" class="hover:bg-gray-50">
                        <td v-for="column in columns" :key="column.key"
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <slot :name="`cell-${column.key}`" :item="item" :value="item[column.key]">
                                {{ item[column.key] }}
                            </slot>
                        </td>
                        <td v-if="showRoute || editRoute || deleteRoute"
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <Link v-if="showRoute" :href="showRoute(item.id)"
                                    class="text-blue-600 hover:text-blue-900">
                                <EyeIcon class="w-5 h-5" />
                                </Link>
                                <Link v-if="editRoute" :href="editRoute(item.id)"
                                    class="text-yellow-600 hover:text-yellow-900">
                                <PencilIcon class="w-5 h-5" />
                                </Link>
                                <button v-if="deleteRoute" @click="confirmDelete(item)"
                                    class="text-red-600 hover:text-red-900">
                                    <TrashIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="data.data.length === 0">
                        <td :colspan="columns.length + 1" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data yang ditemukan
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div v-if="data.links && data.links.length > 3" class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan {{ data.from }} sampai {{ data.to }} dari {{ data.total }} data
                </div>
                <div class="flex space-x-1">
                    <Link v-for="(link, index) in data.links" :key="index" :href="link.url || '#'" v-html="link.label"
                        class="px-3 py-2 text-sm border rounded-md" :class="{
                            'bg-blue-600 text-white border-blue-600': link.active,
                            'text-gray-500 border-gray-300 hover:bg-gray-50': !link.active && link.url,
                            'text-gray-300 border-gray-300 cursor-not-allowed': !link.url
                        }" />
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-lg max-w-md w-full p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Hapus</h3>
                    <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat
                        dibatalkan.</p>
                    <div class="flex justify-end space-x-4">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Batal
                        </button>
                        <button @click="deleteItem" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import {
    MagnifyingGlassIcon,
    PlusIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    ArrowUpTrayIcon
} from '@heroicons/vue/24/outline'
import Lightbox from '@/Components/Lightbox.vue'

const props = defineProps({
    title: String,
    data: Object,
    columns: Array,
    searchable: {
        type: Boolean,
        default: true
    },
    filters: Object,
    createRoute: String,
    showRoute: Function,
    editRoute: Function,
    deleteRoute: Function,
    routeName: String,
    importEnabled: {
        type: Boolean,
        default: false
    }
})

defineEmits(['import'])

const searchQuery = ref('')
const filterValues = ref({})
const showDeleteModal = ref(false)
const itemToDelete = ref(null)

// Initialize filter values
if (props.filters) {
    Object.keys(props.filters).forEach(key => {
        filterValues.value[key] = ''
    })
}

const confirmDelete = (item) => {
    itemToDelete.value = item
    showDeleteModal.value = true
}

const deleteItem = () => {
    if (itemToDelete.value && props.deleteRoute) {
        router.delete(props.deleteRoute(itemToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteModal.value = false
                itemToDelete.value = null
            }
        })
    }
}

// Watch for search and filter changes
watch([searchQuery, filterValues], () => {
    const params = {}

    if (searchQuery.value) {
        params.search = searchQuery.value
    }

    Object.keys(filterValues.value).forEach(key => {
        if (filterValues.value[key]) {
            params[key] = filterValues.value[key]
        }
    })

    if (props.routeName) {
        router.get(route(props.routeName), params, {
            preserveState: true,
            replace: true
        })
    }
}, { deep: true })
</script>
