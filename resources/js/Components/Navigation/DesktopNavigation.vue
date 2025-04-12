<script setup>
import NavLink from '@/Components/NavLink.vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import DropdownLink from '../DropdownLink.vue';
import Dropdown from '../Dropdown.vue';

defineProps({
    navigationLinks: {
        type: Array,
        required: true
    }
});
</script>

<template>
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


                            <Dropdown align="right" width="48" class="inline-flex items-center" v-if="$page.props.auth.user">
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
</template>
