<script setup>
import Tooltip from './Tooltip.vue';

defineProps({
    text: { type: String, required: true },
    icon: { type: String, required: true },
    class: { type: String, default: '' },
})
defineEmits(['click'])
</script>

<template>
    <Tooltip :text="text" location="top">
        <button @click="$emit('click')" :class="[
            'hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer',
        ]">
            <component :is="icon" class="w-5 h-5" />
        </button>
    </Tooltip>
</template>
