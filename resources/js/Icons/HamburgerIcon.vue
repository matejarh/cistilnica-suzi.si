<script setup>
defineProps({
    showingNavigationDropdown: Boolean,
});
</script>

<template>
    <svg stroke="currentColor" fill="none" viewBox="0 0 24 24">
        <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
</template>
