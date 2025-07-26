<template>
    <AdminLayout title="Detail Potensi Desa">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Detail Potensi Desa</h3>
                <div class="flex space-x-2">
                    <Link :href="route('admin.village-potentials.edit', potential.id)"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 flex items-center">
                        <PencilIcon class="w-5 h-5 mr-2" />
                        Edit
                    </Link>
                    <Link :href="route('admin.village-potentials.index', { category: potential.category })"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Kembali
                    </Link>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Nama Potensi</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ potential.title || '-' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Kategori</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="getCategoryClass(potential.category)">
                                {{ getCategoryText(potential.category) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Gambar Potensi</h4>
                        <div>
                            <img :src="getImageUrl(potential.image)"
                                alt="Gambar Potensi"
                                class="w-full max-w-md h-40 object-cover rounded-lg shadow-sm border border-gray-200" />
                        </div>
                    </div>
                </div>

                <div v-if="potential.description" class="mt-6">
                    <h4 class="text-sm font-medium text-gray-700">Deskripsi</h4>
                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ potential.description }}</div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PencilIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    potential: {
        type: Object,
        required: true
    }
});

const getCategoryClass = (category) => {
    const classes = {
        infrastruktur: 'bg-blue-100 text-blue-800',
        sda: 'bg-green-100 text-green-800'
    };
    return classes[category] || 'bg-gray-100 text-gray-800';
};

const getCategoryText = (category) => {
    const texts = {
        infrastruktur: 'Infrastruktur',
        sda: 'Sumber Daya Alam'
    };
    return texts[category] || category;
};

const getImageUrl = (value) => {
    if (!value) {
        return '/placeholder.svg?height=200&width=200';
    }
    const path = value.startsWith('/') ? value.slice(1) : value;
    return `/storage/${path}`;
};
</script>