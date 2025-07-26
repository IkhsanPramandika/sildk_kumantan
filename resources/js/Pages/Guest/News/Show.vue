<template>
    <GuestLayout :title="news.title">
        <!-- Article Content -->
        <article class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Article Header -->
                <header class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ news.title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6">
                        <div class="flex items-center">
                            <CalendarIcon class="w-4 h-4 mr-2" />
                            <span>{{ formatDate(news.published_at) }}</span>
                        </div>
                        <div class="flex items-center">
                            <UserIcon class="w-4 h-4 mr-2" />
                            <span>{{ news.author || 'Admin Desa' }}</span>
                        </div>
                        <div class="flex items-center">
                            <ClockIcon class="w-4 h-4 mr-2" />
                            <span>{{ estimateReadingTime(news.content) }} menit baca</span>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div v-if="news.image_url" class="mb-8">
                        <div class="aspect-video rounded-lg overflow-hidden">
                            <LazyImage
                                :src="`/storage/${news.image_url}` || '/placeholder.svg?height=300&width=600&text=News+Cover'"
                                :alt="news.title"
                                imageClass="w-full h-full object-cover"
                            />
                        </div>
                    </div>
                </header>

                <!-- Article Body -->
                <div class="prose prose-lg max-w-none mb-8">
                    <HtmlContent :content="news.content" />
                </div>

                <!-- Article Footer -->
                <footer class="border-t pt-8">
                    <!-- Share Buttons -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Artikel</h3>
                        <div class="flex flex-wrap gap-3">
                            <button
                                @click="shareToFacebook"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors"
                            >
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </button>
                            <button
                                @click="shareToTwitter"
                                class="inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-medium rounded-lg transition-colors"
                            >
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Twitter
                            </button>
                            <button
                                @click="shareToWhatsApp"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors"
                            >
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                WhatsApp
                            </button>
                            <button
                                @click="printArticle"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors"
                            >
                                <PrinterIcon class="w-4 h-4 mr-2" />
                                Cetak
                            </button>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="flex justify-between items-center">
                        <Link
                            :href="route('news.index')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali ke Berita
                        </Link>

                        <div class="text-sm text-gray-500">
                            Dipublikasikan {{ formatDate(news.published_at) }}
                        </div>
                    </div>
                </footer>
            </div>
        </article>

        <!-- Related News -->
        <section v-if="relatedNews && relatedNews.length > 0" class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Berita Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <article
                        v-for="article in relatedNews"
                        :key="article.id"
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
                    >
                        <div class="h-48 overflow-hidden">
                            <LazyImage
                                :src="article.image_url || '/placeholder.svg?height=300&width=600&text=News+Cover'"
                                :alt="article.title"
                                imageClass="w-full h-full object-cover"
                            />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <CalendarIcon class="w-4 h-4 mr-2" />
                                <span>{{ formatDate(article.published_at) }}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                <Link :href="route('news.show', { news: article.slug })" class="hover:text-red-600 transition-colors">
                                    {{ article.title }}
                                </Link>
                            </h3>
                            <div class="text-gray-600 text-sm line-clamp-2" v-html="article.excerpt || article.content"></div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import LazyImage from '@/Components/LazyImage.vue'
import HtmlContent from '@/Components/Guest/HtmlContent.vue'
import {
    CalendarIcon,
    UserIcon,
    ClockIcon,
    ChevronRightIcon,
    ArrowLeftIcon,
    PrinterIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    news: {
        type: Object,
        required: true
    },
    relatedNews: {
        type: Array,
        default: () => []
    }
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const estimateReadingTime = (content) => {
    const wordsPerMinute = 200
    const words = content.replace(/<[^>]*>/g, '').split(/\s+/).length
    return Math.ceil(words / wordsPerMinute)
}

const shareToFacebook = () => {
    const url = encodeURIComponent(window.location.href)
    const title = encodeURIComponent(props.news.title)
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${title}`, '_blank')
}

const shareToTwitter = () => {
    const url = encodeURIComponent(window.location.href)
    const title = encodeURIComponent(props.news.title)
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank')
}

const shareToWhatsApp = () => {
    const url = encodeURIComponent(window.location.href)
    const title = encodeURIComponent(props.news.title)
    window.open(`https://wa.me/?text=${title} ${url}`, '_blank')
}

const printArticle = () => {
    window.print()
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media print {
    .no-print {
        display: none !important;
    }
}
</style>
