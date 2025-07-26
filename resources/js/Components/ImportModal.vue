<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Import Excel Data
            </h2>

            <div class="mt-6">
                <form @submit.prevent="submitForm" class="space-y-6">
                    <div>
                        <InputLabel for="file" value="Excel File" />
                        <input
                            type="file"
                            id="file"
                            ref="fileInput"
                            class="mt-1 block w-full"
                            accept=".xlsx,.xls,.csv"
                            @change="handleFileChange"
                        />
                        <InputError :message="form.errors.file" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal" class="mr-3">
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Import
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from './Modal.vue';
import InputLabel from './InputLabel.vue';
import InputError from './InputError.vue';
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const fileInput = ref(null);
const form = useForm({
    file: null,
});

const handleFileChange = (e) => {
    form.file = e.target.files[0];
};

const submitForm = () => {
    form.post(route('admin.residents.import'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            closeModal();
        },
    });
};

const closeModal = () => {
    form.reset();
    emit('close');
};
</script>
