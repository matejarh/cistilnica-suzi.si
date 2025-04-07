<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const year = computed(() => new Date().getFullYear());

const links = [
    { route: 'about', label: 'O nas' },
    { route: 'prices', label: 'Cenik' },
    { route: 'contact', label: 'Kontakt' },
    { route: 'prijava', label: 'Prijava na akcije' },
];
</script>

<template>
    <footer class="bg-primary shadow-sm mt-4 absolute bottom-0 w-full bg-opacity-60 backdrop-blur-md">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-neutral-light sm:text-center">
                © {{ year }}
                <Link :href="route('home')" class="hover:underline">Čistilnica Suzi</Link>.
                Vse pravice pridržane.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-neutral-light sm:mt-0">
                <li v-for="link in links" :key="link.route" class="me-4 md:me-6">
                    <Link :href="route(link.route)" class="hover:underline">{{ link.label }}</Link>
                </li>
            </ul>
        </div>
    </footer>
</template>

<style scoped>
/* Add any footer-specific styles here if needed */
</style>
