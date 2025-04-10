<script setup>
import { computed } from 'vue';

const year = computed(() => new Date().getFullYear());

const appName = import.meta.env.VITE_APP_NAME;

const links = [
    { route: 'public.about', label: 'O nas' },
    { route: 'public.offers', label: 'Ponudba' },
    { route: 'public.contact', label: 'Kontakt' },
    { route: 'public.prijava', label: 'Prijava na akcije' },
];
</script>

<template>
    <footer class="bg-primary shadow-sm mt-4 absolute bottom-0 w-full bg-opacity-60 backdrop-blur-sm z-10">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-neutral-light sm:text-center items-center flex">
                © {{ year }}
                <img src="@images/favicon.png" alt="Logo" class="inline-block h-5 w-5 ms-2 me-1" />
                <inertia-link :href="route('public.home')" class="hover:underline">{{ appName }}</inertia-link>.
                Vse pravice pridržane.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-neutral-light sm:mt-0">
                <li v-for="link in links" :key="link.route" class="me-4 md:me-6">
                    <inertia-link :href="route(link.route)" class="hover:underline">{{ link.label }}</inertia-link>
                </li>
            </ul>
        </div>
    </footer>
</template>

<style scoped>
/* Add any footer-specific styles here if needed */
</style>
