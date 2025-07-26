<template>
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
            <component :is="icon" class="w-8 h-8" />
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ value }}</h3>
        <p class="text-gray-600">{{ label }}</p>
    </div>
</template>

<script setup>
defineProps({
    icon: {
        type: Object,
        required: true
    },
    value: {
        type: [String, Number],
        required: true
    },
    label: {
        type: String,
        required: true
    }
})
</script>
