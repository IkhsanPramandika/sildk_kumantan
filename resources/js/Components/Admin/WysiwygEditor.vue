<template>
    <div>
        <div v-if="error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ error }}
        </div>
        <div v-if="loading" class="mb-4 p-4 bg-gray-100 border border-gray-400 text-gray-700 rounded">
            Memuat editor...
        </div>
        <textarea ref="editor" :value="modelValue" @input="updateValue"></textarea>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch, shallowRef } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    wysiwygHeight: {
        type: Number,
        default: 400
    }
});

const emit = defineEmits(['update:modelValue']);

const editor = ref(null);
const editorInstance = shallowRef(null);
const error = ref(null);
const loading = ref(true);

const initEditor = async () => {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            error.value = 'CSRF token tidak ditemukan. Silakan refresh halaman.';
            loading.value = false;
            return;
        }

        const newEditor = await ClassicEditor.create(editor.value, {
            ckfinder: {
                uploadUrl: route('ckeditor.upload')
            },
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'undo',
                    'redo'
                ]
            },
            language: 'id',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            }
        });

        editorInstance.value = newEditor;
        // Initialize editor with existing content
        newEditor.setData(props.modelValue);
        newEditor.model.document.on('change:data', () => {
            emit('update:modelValue', newEditor.getData());
        });
        loading.value = false;
    } catch (err) {
        console.error('Error initializing editor:', err);
        error.value = 'Gagal memuat editor. Silakan refresh halaman.';
        loading.value = false;
    }
};

const destroyEditor = async () => {
    if (editorInstance.value) {
        try {
            const editor = editorInstance.value;
            editorInstance.value = null;
            await editor.destroy();
        } catch (err) {
            console.error('Error destroying editor:', err);
        }
    }
};

onMounted(() => {
    initEditor();
});

onBeforeUnmount(() => {
    destroyEditor();
});

watch(() => props.modelValue, (newValue) => {
    if (editorInstance.value && editorInstance.value.getData() !== newValue) {
        editorInstance.value.setData(newValue);
    }
});

const updateValue = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<style>
.ck-editor__editable {
    min-height: v-bind('wysiwygHeight + "px"');
}
</style>
