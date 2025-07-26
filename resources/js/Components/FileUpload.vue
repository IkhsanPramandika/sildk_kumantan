<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-2">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>

        <div class="space-y-4">
            <!-- File Input -->
            <div class="flex items-center justify-center w-full">
                <label :for="inputId"
                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors"
                    :class="{ 'border-red-500 bg-red-50': error }">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500">
                            <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                        </p>
                        <p class="text-xs text-gray-500">{{ acceptText || 'PNG, JPG atau JPEG (MAX. 2MB)' }}</p>
                        <p v-if="multiple" class="text-xs text-blue-500 mt-1">Dapat memilih beberapa file sekaligus</p>
                    </div>
                    <input
                        :id="inputId"
                        type="file"
                        class="hidden"
                        :multiple="multiple"
                        :accept="accept"
                        @change="handleFileUpload"
                    />
                </label>
            </div>

            <!-- Image Previews with Captions -->
            <div v-if="images.length > 0" class="mt-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div v-for="(image, index) in images" :key="index" class="relative group">
                        <div class="relative">
                            <LazyImage
                                :src="image.preview"
                                :alt="`Preview ${index + 1}`"
                                imageClass="w-full h-32 object-cover rounded-lg shadow-sm border border-gray-200"
                            />
                            <button type="button" @click="removeImage(index)"
                                class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div v-if="showCaptions" class="mt-2">
                            <input type="text" v-model="captions[index]"
                                class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                :placeholder="`Caption untuk gambar ${index + 1} (opsional)`" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- File List for Non-Image Files -->
            <div v-if="files.length > 0 && !isImageUpload" class="mt-4">
                <div class="space-y-2">
                    <div v-for="(file, index) in files" :key="index"
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ file.file.name }}</p>
                                <p class="text-xs text-gray-500">{{ formatFileSize(file.file.size) }}</p>
                            </div>
                        </div>
                        <button type="button" @click="removeFile(index)"
                            class="p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                                </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>

        <!-- Help Text -->
        <p v-if="help" class="mt-1 text-sm text-gray-500">{{ help }}</p>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import LazyImage from '@/Components/LazyImage.vue';

const props = defineProps({
    label: String,
    required: Boolean,
    multiple: {
        type: Boolean,
        default: true
    },
    accept: {
        type: String,
        default: 'image/*'
    },
    acceptText: String,
    maxSize: {
        type: Number,
        default: 2 * 1024 * 1024 // 2MB
    },
    showCaptions: {
        type: Boolean,
        default: true
    },
    error: String,
    help: String,
    modelValue: {
        type: Array,
        default: () => []
    },
    captionsValue: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['update:modelValue', 'update:captionsValue']);

const inputId = `file-upload-${Math.random().toString(36).substr(2, 9)}`;
const images = ref([]);
const files = ref([]);
const captions = ref([]);

const isImageUpload = computed(() => {
    return props.accept.includes('image');
});

// Initialize from props
watch(() => props.modelValue, (newValue) => {
    if (newValue && newValue.length > 0) {
        if (isImageUpload.value) {
            images.value = newValue;
        } else {
            files.value = newValue;
        }
    } else {
        // Clear images/files when modelValue is empty
        images.value = [];
        files.value = [];
    }
}, { immediate: true });

watch(() => props.captionsValue, (newValue) => {
    if (newValue) {
        captions.value = newValue;
    }
}, { immediate: true });

const handleFileUpload = (event) => {
    const input = event.target;
    if (input.files) {
        const newFiles = Array.from(input.files);

        // If multiple is false, only take the first file and clear existing images
        const filesToProcess = props.multiple ? newFiles : [newFiles[0]];

        if (!props.multiple) {
            images.value = []; // Clear existing images when multiple is false
            captions.value = [];
        }

        filesToProcess.forEach(file => {
            // Check file size
            if (file.size > props.maxSize) {
                alert(`Ukuran file "${file.name}" terlalu besar. Maksimal ${formatFileSize(props.maxSize)} per file.`);
                return;
            }

            if (isImageUpload.value) {
                // Handle image files
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageData = {
                        file,
                        preview: e.target.result
                    };
                    images.value.push(imageData);
                    captions.value.push('');

                    emit('update:modelValue', images.value);
                    emit('update:captionsValue', captions.value);
                };
                reader.readAsDataURL(file);
            } else {
                // Handle other files
                const fileData = {
                    file,
                    name: file.name,
                    size: file.size
                };
                files.value.push(fileData);
                emit('update:modelValue', files.value);
            }
        });
    }

    // Reset input
    input.value = '';
};

const removeImage = (index) => {
    images.value.splice(index, 1);
    captions.value.splice(index, 1);

    emit('update:modelValue', images.value);
    emit('update:captionsValue', captions.value);
};

const removeFile = (index) => {
    files.value.splice(index, 1);
    emit('update:modelValue', files.value);
};

const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

// Watch captions changes
watch(captions, (newCaptions) => {
    emit('update:captionsValue', newCaptions);
}, { deep: true });
</script>
