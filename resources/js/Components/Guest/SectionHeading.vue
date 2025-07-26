<template>
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ title }}</h2>
        <div v-if="subtitle" class="text-lg text-gray-600">{{ subtitle }}</div>
        <div v-if="$slots.default" class="mt-4 max-w-3xl mx-auto text-gray-600">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    subtitle: {
        type: String,
        default: ''
    }
})
</script>
