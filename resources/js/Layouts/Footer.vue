<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const year = computed(() => new Date().getFullYear());

const appName = import.meta.env.VITE_APP_NAME;

const links = [
    { route: 'public.about', label: 'O nas' },
    { route: 'public.offers', label: 'Ponudba' },
    { route: 'public.contact', label: 'Kontakt' },
    { route: 'public.akcije', label: 'Akcije' },
    { route: page.props.auth.user ? 'dashboard' : 'login', label: page.props.auth.user ? 'Administracija' : 'Prijava ' },
];
</script>

<template>
    <footer class="bg-primary/60 shadow-xs mt-4 absolute bottom-0 w-full backdrop-blur-xs z-10">
        <div class="w-full mx-auto max-w-(--breakpoint-xl) p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-neutral-light sm:text-center items-center flex">
                © {{ year }}
                <img src="@images/favicon.png" alt="Logo" class="inline-block h-5 w-5 ms-2 me-1" />
                <inertia-link :href="route('public.home')" class="hover:underline">{{ appName }}</inertia-link>.
                Vse pravice pridržane.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-neutral-light sm:mt-0">
                <li v-for="link in links" :key="link.route" class="me-4 md:me-6">
                    <inertia-link :href="route(link.route)" class="hover:underline" :class="{'font-bold underline' : route().current(link.route)}">{{ link.label }}</inertia-link>
                </li>
            </ul>
        </div>
    </footer>
</template>

<style scoped>
/* Add any footer-specific styles here if needed */
</style>
