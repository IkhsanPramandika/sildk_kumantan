<template>
    <div class="space-y-2">
        <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>

        <!-- Text Input -->
        <input v-if="type === 'text' || type === 'email' || type === 'password' || type === 'number'" :id="id"
            :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder" :required="required" :disabled="disabled"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100"
            :class="{ 'border-red-500': error }" />

        <!-- Textarea -->
        <textarea v-else-if="type === 'textarea'" :id="id" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)" :placeholder="placeholder" :required="required"
            :disabled="disabled" :rows="rows"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100"
            :class="{ 'border-red-500': error }"></textarea>

        <!-- Select -->
        <select v-else-if="type === 'select'" :id="id" :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)" :required="required" :disabled="disabled"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100"
            :class="{ 'border-red-500': error }">
            <option value="" v-if="placeholder">{{ placeholder }}</option>
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.label }}
            </option>
        </select>

        <!-- File Input -->
        <input v-else-if="type === 'file'" :id="id" type="file"
            @change="$emit('update:modelValue', $event.target.files[0])" :accept="accept" :required="required"
            :disabled="disabled"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100"
            :class="{ 'border-red-500': error }" />

        <!-- Date Input -->
        <input v-else-if="type === 'date'" :id="id" type="date" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)" :required="required" :disabled="disabled"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100"
            :class="{ 'border-red-500': error }" />

        <!-- WYSIWYG Editor -->
        <WysiwygEditor v-else-if="type === 'wysiwyg'" :id="id" :label="label"
            :modelValue="modelValue" @update:modelValue="$emit('update:modelValue', $event)"
            :placeholder="placeholder" :required="required" :disabled="disabled"
            :error="error" :help="help" :wysiwygHeight="wysiwygHeight" />

        <!-- Error Message -->
        <p v-if="error" class="text-sm text-red-600">{{ error }}</p>

        <!-- Help Text -->
        <p v-if="help" class="text-sm text-gray-500">{{ help }}</p>
    </div>
</template>

<script setup>
import WysiwygEditor from './Admin/WysiwygEditor.vue'

defineProps({
    id: String,
    label: String,
    type: {
        type: String,
        default: 'text'
    },
    modelValue: [String, Number, File],
    placeholder: String,
    required: Boolean,
    disabled: Boolean,
    error: String,
    help: String,
    options: Array,
    accept: String,
    rows: {
        type: Number,
        default: 4
    },
    wysiwygHeight: {
        type: Number,
        default: 400
    }
})

defineEmits(['update:modelValue'])
</script>
