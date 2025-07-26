<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="relative">
      <LazyImage :src="product.image_url" :alt="product.name" class="w-full h-48 object-cover" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
      <div class="absolute bottom-0 left-0 right-0 p-4">
        <h3 class="text-xl font-semibold text-white mb-2">{{ product.name }}</h3>
        <div class="flex items-center text-white/90 text-sm">
          <span class="font-medium">Rp {{ formatPrice(product.price) }}</span>
        </div>
      </div>
    </div>
    <div class="p-4">
      <p class="text-gray-600 text-sm mb-4">{{ truncateDescription(product.description) }}</p>
      <div class="flex justify-between items-center">
        <span class="text-sm text-gray-500">{{ product.category }}</span>
        <Link :href="route('products.show', { product: product.slug })" class="text-blue-600 hover:text-blue-800 text-sm">
          Lihat Detail
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import LazyImage from '@/Components/LazyImage.vue'

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const formatPrice = (price) => {
  return new Intl.NumberFormat('id-ID').format(price)
}

const truncateDescription = (text) => {
  return text.length > 100 ? text.substring(0, 100) + '...' : text
}
</script>
