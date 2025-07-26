<template>
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
        </div>

        <form @submit.prevent="$emit('submit')" class="p-6 space-y-6">
            <slot />

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <Link :href="cancelRoute"
                    class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                Batal
                </Link>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50">
                    <span v-if="loading">Menyimpan...</span>
                    <span v-else>{{ submitText }}</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    title: String,
    cancelRoute: String,
    submitText: {
        type: String,
        default: 'Simpan'
    },
    loading: {
        type: Boolean,
        default: false
    }
})

defineEmits(['submit'])
</script>
