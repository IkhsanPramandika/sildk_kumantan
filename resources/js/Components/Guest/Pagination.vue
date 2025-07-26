<template>
    <div v-if="links.length > 3" class="flex justify-center mt-8">
        <nav class="flex items-center space-x-1">
            <template v-for="(link, index) in links" :key="index">
                <div v-if="link.url === null"
                    class="px-4 py-2 text-sm text-gray-500 border border-gray-300 rounded-md cursor-not-allowed"
                    v-html="link.label">
                </div>
                <Link v-else :href="link.url" class="px-4 py-2 text-sm border rounded-md" :class="{
                    'bg-blue-600 text-white border-blue-600': link.active,
                    'text-gray-700 border-gray-300 hover:bg-gray-50': !link.active
                }" v-html="link.label">
                </Link>
            </template>
        </nav>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array,
        required: true
    }
})
</script>
