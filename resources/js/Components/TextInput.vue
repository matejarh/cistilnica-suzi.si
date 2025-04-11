<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: String,
    placeholder: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    id: {
        type: String,
        default: '',
    },
    autofocus: {
        type: Boolean,
        default: false,
    },
    hasError: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (props.autofocus && input.value) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        :id="id"
        :type="type"
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :class="[
            'block w-full p-3 pl-10 text-sm rounded-lg border focus:ring-primary focus:border-primary',
            hasError ? 'bg-red-100 border-red-500 text-red-900 placeholder-red-500 focus:ring-red-500 focus:border-red-500' : 'bg-neutral-light border-neutral-light text-neutral-dark placeholder-neutral-dark',
        ]"
    />
</template>
