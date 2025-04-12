<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import EnvelopeIcon from '@/Icons/EnvelopeIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showingNavigationDropdown = ref(false);

const navigationLinks = [
    { name: 'Domov', route: 'public.home' },
    { name: 'O nas', route: 'public.about' },
    { name: 'Ponudba', route: 'public.offers' },
    { name: 'Kontakt', route: 'public.contact' },
];

// Close the dropdown when clicking outside
const handleClickOutside = (event) => {
    const dropdown = document.querySelector('.responsive-nav-menu');
    const hamburger = document.querySelector('.hamburger-button');
    if (
        dropdown &&
        !dropdown.contains(event.target) &&
        hamburger &&
        !hamburger.contains(event.target)
    ) {
        showingNavigationDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="">
        <nav class="bg-primary/70 border-b border-primary-light z-50 backdrop-blur-md relative w-full top-0">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <inertia-link :href="route('public.home')">
                                <ApplicationMark class="block h-14 w-auto" />
                            </inertia-link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink v-for="link in navigationLinks" :key="link.route" :href="route(link.route)"
                                :active="route().current(link.route)">
                                {{ link.name }}
                            </NavLink>
                        </div>
                    </div>
                    <div class="flex">

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink :href="route('public.akcije')" :active="route().current('public.akcije')">
                                Akcije
                            </NavLink>


                            <Dropdown align="right" width="48" class="inline-flex items-center">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-hidden focus:border-gray-300 transition">
                                        <img class="size-8 rounded-full object-cover"
                                            :src="$page.props.auth.user.profile_photo_url"
                                            :alt="$page.props.auth.user.name">
                                    </button>

                                    <span v-else class="">
                                        <button type="button"
                                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-secondary-500 dark:text-secondary-400 hover:text-secondary-700 dark:hover:text-secondary-300 hover:border-secondary-300 dark:hover:border-secondary-700 focus:outline-hidden focus:text-secondary-700 dark:focus:text-secondary-300 focus:border-secondary-300 dark:focus:border-secondary-700 transition duration-150 ease-in-out">
                                            {{ $page.props.auth.user.name }}

                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-neutral-light">
                                        Upravljanje z računom
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Moj profil
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                        :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-neutral-light" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Odjava
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>


                        </div>
                    </div>

                    <!-- Hamburger Menu -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            class="hamburger-button inline-flex items-center justify-center p-2 rounded-md text-neutral-light hover:text-white hover:bg-primary-light focus:outline-hidden focus:bg-primary-light focus:text-white transition duration-150 ease-in-out"
                            @click.stop="showingNavigationDropdown = !showingNavigationDropdown">
                            <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path
                                    :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <Transition enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 transform scale-y-0" enter-to-class="opacity-100 transform scale-y-100"
                leave-active-class="transition-all duration-300 ease-in"
                leave-from-class="opacity-100 transform scale-y-100" leave-to-class="opacity-0 transform scale-y-0">
                <div v-if="showingNavigationDropdown"
                    class="responsive-nav-menu sm:hidden absolute right-0 z-50 w-56 mt-1 origin-top-right bg-primary divide-y divide-primary-light rounded-md shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink v-for="link in navigationLinks" :key="link.route" :href="route(link.route)"
                            :active="route().current(link.route)">
                            {{ link.name }}
                        </ResponsiveNavLink>
                        <hr class="border-neutral-light mb-4" />
                        <ResponsiveNavLink :href="route('public.akcije')" :active="route().current('public.akcije')"
                            class="">
                            <div class="flex items-center">
                                <EnvelopeIcon :is-opened="route().current('public.akcije')"
                                    class="w-6 h-6 me-2 text-neutral-light" />
                                <span class="text-neutral-light font-medium">Akcije</span>
                            </div>
                        </ResponsiveNavLink>
                    </div>
                </div>
            </Transition>
        </nav>
    </div>
</template>
