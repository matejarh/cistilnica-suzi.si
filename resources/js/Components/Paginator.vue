<template>
    <nav v-if="filteredLinks.length > 3" class="flex justify-center mt-4">
        <ul class="flex flex-wrap justify-center gap-2 sm:gap-4">
            <li v-for="link in filteredLinks" :key="link.label" class="flex">
                <!-- Render "Three Dots" Separator -->
                <span
                    v-if="!link.url && !link.active"
                    class="px-3 py-2 border rounded bg-neutral-200 text-neutral-500 cursor-not-allowed text-xs sm:text-sm"
                    v-html="link.label"
                ></span>

                <!-- Render Active or Inactive Links -->
                <inertia-link
                    v-else-if="link.url"
                    :href="link.url"
                    :class="[
                        'px-3 py-2 border rounded text-xs sm:text-sm',
                        link.active ? 'bg-primary text-white' : 'bg-white text-primary hover:bg-primary-light hover:text-white',
                    ]"
                >
                    <span v-html="link.label"></span>
                </inertia-link>

                <!-- Render Disabled Links -->
                <span
                    v-else
                    class="px-3 py-2 border rounded bg-neutral-200 text-neutral-500 cursor-not-allowed text-xs sm:text-sm"
                    v-html="link.label"
                ></span>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
    forEachSide: {
        type: Number,
        default: 1, // Default to showing 1 link on each side of the current page
    },
});

// Filter links based on the forEachSide prop
const filteredLinks = computed(() => {
    const currentIndex = props.links.findIndex((link) => link.active);
    if (currentIndex === -1) return props.links;

    const start = Math.max(1, currentIndex - props.forEachSide); // Start after the first link
    const end = Math.min(props.links.length - 1, currentIndex + props.forEachSide + 1); // End before the last link

    const previousLink = props.links.find((link) => link.label === 'Previous');
    const nextLink = props.links.find((link) => link.label === 'Next');

    return [
        ...(previousLink ? [previousLink] : []), // Include the "Previous" link if it exists
        props.links[0], // Always include the first link
        ...(start > 1 ? [{ label: '...', url: null }] : []), // Add "Three Dots" before the range if needed
        ...props.links.slice(start, end), // Include the range of links around the current page
        ...(end < props.links.length - 1 ? [{ label: '...', url: null }] : []), // Add "Three Dots" after the range if needed
        props.links[props.links.length - 1], // Always include the last link
        ...(nextLink ? [nextLink] : []), // Include the "Next" link if it exists
    ];
});
</script>
