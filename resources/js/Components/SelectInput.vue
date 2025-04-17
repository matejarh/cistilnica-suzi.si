<template>
    <select
        v-model="internalValue"
        :placeholder="placeholder"
        :class="[
            'block w-full pl-4 pr-10 py-2 text-sm rounded-lg border-2 focus:ring-primary focus:border-primary',
            hasError ? 'bg-red-100 border-red-500 text-red-900 placeholder-red-500 focus:ring-red-500 focus:border-red-500' : 'bg-neutral-light border-primary text-neutral-dark placeholder-neutral-dark',
        ]">
        <slot />
    </select>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean],
        required: true,
    },
    hasError: {
        type: Boolean,
        default: false,
    },
    placeholder: {
        type: String,
        default: '-- izberi --',
    },
});

const internalValue = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});
const emit = defineEmits(['update:modelValue']);
</script>
