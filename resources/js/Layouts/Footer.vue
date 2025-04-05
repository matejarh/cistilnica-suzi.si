<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const year = computed(() => new Date().getFullYear());
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
                <li>
                    <Link :href="route('about')" class="hover:underline me-4 md:me-6">O nas</Link>
                </li>
                <li>
                    <Link :href="route('prices')" class="hover:underline me-4 md:me-6">Cenik</Link>
                </li>
                <li>
                    <Link :href="route('contact')" class="hover:underline me-4 md:me-6">Kontakt</Link>
                </li>
                <li>
                    <Link :href="route('prijava')" class="hover:underline">Prijava na akcije</Link>
                </li>
            </ul>
        </div>
    </footer>
</template>

<style scoped>
/* Add any footer-specific styles here if needed */
</style>
