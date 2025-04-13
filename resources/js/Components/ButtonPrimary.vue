<script setup>
defineProps({
    href: {
        type: String,
        default: '#',
    },
    as: {
        type: String,
        default: 'a',
    },
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <inertia-link v-if="(as === 'link')" :href="href"
        class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-primary-light focus:ring-4 focus:ring-primary">
       <slot />
    </inertia-link>
    <button v-else-if="(as === 'button')" :type="type" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest   focus:bg-primary-light active:bg-primary-light focus:outline-hidden focus:ring-2 focus:ring-primary-dark focus:ring-offset-2  disabled:opacity-50 transition ease-in-out duration-150">
        <slot />
    </button>
    <a v-else :href="href"
        class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-primary-light focus:ring-4 focus:ring-primary">
       <slot />
    </a>
</template>
