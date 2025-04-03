<script setup>
defineProps({
    href: {
        type: String,
        required: true,
    },
    as: {
        type: String,
        default: 'a',
    },
});
</script>

<template>
    <inertia-link v-if="(as === 'link')" :href="href"
        class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-primary-light focus:ring-4 focus:ring-primary">
       <slot />
    </inertia-link>
</template>
