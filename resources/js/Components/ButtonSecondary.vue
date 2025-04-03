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
    <inertia-link v-if="(as === 'link')" :href="href" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-neutral-light border border-neutral-light rounded-lg hover:bg-neutral-light hover:text-neutral-dark focus:ring-4 focus:ring-neutral-light ">
        <slot />
    </inertia-link>

</template>
