<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-5 py-3 bg-primary hover:bg-primary-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest   focus:bg-primary-light active:bg-primary-light focus:outline-hidden focus:ring-2 focus:ring-primary-dark focus:ring-offset-2  disabled:opacity-50 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
