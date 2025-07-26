<template>
    <span>{{ displayValue }}</span>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'

const props = defineProps({
    value: {
        type: Number,
        required: true
    },
    duration: {
        type: Number,
        default: 1000
    },
    format: {
        type: Function,
        default: (value) => new Intl.NumberFormat('id-ID').format(Math.round(value))
    }
})

const displayValue = ref(0)

const animateNumber = () => {
    const startValue = 0
    const endValue = props.value
    const startTime = Date.now()
    
    const updateValue = () => {
        const currentTime = Date.now()
        const elapsed = currentTime - startTime
        const progress = Math.min(elapsed / props.duration, 1)
        
        // Easing function for smooth animation
        const easeOutQuart = 1 - Math.pow(1 - progress, 4)
        
        const currentValue = startValue + (endValue - startValue) * easeOutQuart
        displayValue.value = props.format(currentValue)
        
        if (progress < 1) {
            requestAnimationFrame(updateValue)
        }
    }
    
    requestAnimationFrame(updateValue)
}

onMounted(() => {
    setTimeout(animateNumber, 200)
})

watch(() => props.value, () => {
    animateNumber()
})
</script>
