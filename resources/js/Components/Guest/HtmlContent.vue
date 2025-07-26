<template>
    <div 
        class="prose prose-blue max-w-none"
        :class="[
            size === 'sm' ? 'prose-sm' : '',
            size === 'lg' ? 'prose-lg' : '',
            size === 'xl' ? 'prose-xl' : '',
            customClass
        ]"
        v-html="sanitizedContent"
    ></div>
</template>

<script setup>
import { computed } from 'vue'
import DOMPurify from 'dompurify'

const props = defineProps({
    content: {
        type: String,
        default: ''
    },
    size: {
        type: String,
        default: 'base', // sm, base, lg, xl
        validator: (value) => ['sm', 'base', 'lg', 'xl'].includes(value)
    },
    customClass: {
        type: String,
        default: ''
    },
    allowedTags: {
        type: Array,
        default: () => [
            'p', 'br', 'strong', 'em', 'u', 's', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'ul', 'ol', 'li', 'blockquote', 'a', 'img', 'table', 'thead', 'tbody',
            'tr', 'th', 'td', 'div', 'span', 'pre', 'code'
        ]
    },
    allowedAttributes: {
        type: Object,
        default: () => ({
            'a': ['href', 'title', 'target'],
            'img': ['src', 'alt', 'title', 'width', 'height'],
            'table': ['class'],
            'td': ['colspan', 'rowspan'],
            'th': ['colspan', 'rowspan'],
            '*': ['class', 'style']
        })
    }
})

const sanitizedContent = computed(() => {
    if (!props.content) return ''
    
    // Configure DOMPurify
    const config = {
        ALLOWED_TAGS: props.allowedTags,
        ALLOWED_ATTR: Object.keys(props.allowedAttributes).reduce((acc, tag) => {
            if (tag === '*') {
                acc.push(...props.allowedAttributes[tag])
            } else {
                acc.push(...props.allowedAttributes[tag])
            }
            return acc
        }, []),
        ALLOW_DATA_ATTR: false,
        ALLOW_UNKNOWN_PROTOCOLS: false
    }
    
    return DOMPurify.sanitize(props.content, config)
})
</script>

<style>
/* Custom prose styles for better content rendering */
.prose {
    color: #374151;
    max-width: none;
}

.prose p {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
}

.prose img {
    margin-top: 2em;
    margin-bottom: 2em;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.prose blockquote {
    font-weight: 500;
    font-style: italic;
    color: #374151;
    border-left-width: 0.25rem;
    border-left-color: #3b82f6;
    quotes: "\201C""\201D""\2018""\2019";
    margin-top: 1.6em;
    margin-bottom: 1.6em;
    padding-left: 1em;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #111827;
    font-weight: 600;
    line-height: 1.25;
}

.prose h1 {
    font-size: 2.25em;
    margin-top: 0;
    margin-bottom: 0.8888889em;
}

.prose h2 {
    font-size: 1.5em;
    margin-top: 2em;
    margin-bottom: 1em;
}

.prose h3 {
    font-size: 1.25em;
    margin-top: 1.6em;
    margin-bottom: 0.6em;
}

.prose ul, .prose ol {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}

.prose li {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

.prose table {
    width: 100%;
    table-layout: auto;
    text-align: left;
    margin-top: 2em;
    margin-bottom: 2em;
    font-size: 0.875em;
    line-height: 1.7142857;
}

.prose thead {
    border-bottom-width: 1px;
    border-bottom-color: #d1d5db;
}

.prose thead th {
    color: #111827;
    font-weight: 600;
    vertical-align: bottom;
    padding-right: 0.5714286em;
    padding-bottom: 0.5714286em;
    padding-left: 0.5714286em;
}

.prose tbody tr {
    border-bottom-width: 1px;
    border-bottom-color: #e5e7eb;
}

.prose tbody td {
    vertical-align: baseline;
    padding-top: 0.5714286em;
    padding-right: 0.5714286em;
    padding-bottom: 0.5714286em;
    padding-left: 0.5714286em;
}

.prose a {
    color: #3b82f6;
    text-decoration: underline;
    font-weight: 500;
}

.prose a:hover {
    color: #1d4ed8;
}

.prose code {
    color: #111827;
    font-weight: 600;
    font-size: 0.875em;
    background-color: #f3f4f6;
    padding: 0.25em 0.375em;
    border-radius: 0.25rem;
}

.prose pre {
    color: #e5e7eb;
    background-color: #1f2937;
    overflow-x: auto;
    font-weight: 400;
    font-size: 0.875em;
    line-height: 1.7142857;
    margin-top: 1.7142857em;
    margin-bottom: 1.7142857em;
    border-radius: 0.375rem;
    padding: 0.8571429em 1.1428571em;
}

.prose pre code {
    background-color: transparent;
    border-width: 0;
    border-radius: 0;
    padding: 0;
    font-weight: inherit;
    color: inherit;
    font-size: inherit;
    font-family: inherit;
    line-height: inherit;
}
</style>
