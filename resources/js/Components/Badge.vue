<script setup>
import { computed } from 'vue';

const props = defineProps({
    color: {
        type: String,
        default: 'blue',
    },
});

const classes = computed(() => {
    return {
        'blue': 'bg-primary text-neutral-light',
        'green': 'bg-green-800 text-neutral-light',
        'red': 'bg-red-800 text-neutral-light',
        'yellow': 'bg-yellow-800 text-neutral-light',
        'purple': 'bg-purple-800 text-neutral-light',
        'pink': 'bg-pink-800 text-neutral-light',
        'gray': 'bg-gray-800 text-neutral-light',
    }[props.color];
});

</script>


<template>
    <span class=" text-xs font-medium me-2 px-2.5 py-0.5 rounded-full" :class="classes">
        <slot />
    </span>
</template>
