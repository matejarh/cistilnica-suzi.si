<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import EnvelopeIcon from '@/Icons/EnvelopeIcon.vue';

const showingNavigationDropdown = ref(false);

const navigationLinks = [
    { name: 'Domov', route: 'home' },
    { name: 'O nas', route: 'about' },
    { name: 'Ponudba', route: 'offers' },
    { name: 'Kontakt', route: 'contact' },
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
    <nav class="bg-primary border-b border-primary-light z-50 bg-opacity-70 backdrop-blur-md relative">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')">
                            <ApplicationMark class="block h-14 w-auto" />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink
                            v-for="link in navigationLinks"
                            :key="link.route"
                            :href="route(link.route)"
                            :active="route().current(link.route)"
                        >
                            {{ link.name }}
                        </NavLink>
                    </div>
                </div>

                <!-- Additional Actions -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="ms-3 relative">
                        <Link
                            class="text-center flex justify-center items-center flex-col active:font-bold"
                            :href="route('prijava')"
                            :active="route().current('prijava')"
                        >
                            <EnvelopeIcon :is-opened="route().current('prijava')" class="w-6 h-6 text-neutral-light" />
                            <span class="text-neutral-light text-sm font-medium">Prijava na akcije</span>
                        </Link>
                    </div>
                </div>

                <!-- Hamburger Menu -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button
                        class="hamburger-button inline-flex items-center justify-center p-2 rounded-md text-neutral-light hover:text-white hover:bg-primary-light focus:outline-none focus:bg-primary-light focus:text-white transition duration-150 ease-in-out"
                        @click.stop="showingNavigationDropdown = !showingNavigationDropdown"
                    >
                        <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 transform scale-y-0"
            enter-to-class="opacity-100 transform scale-y-100"
            leave-active-class="transition-all duration-300 ease-in"
            leave-from-class="opacity-100 transform scale-y-100"
            leave-to-class="opacity-0 transform scale-y-0"
        >
            <div
                v-if="showingNavigationDropdown"
                class="responsive-nav-menu sm:hidden absolute right-0 z-50 w-56 mt-1 origin-top-right bg-primary divide-y divide-primary-light rounded-md shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink
                        v-for="link in navigationLinks"
                        :key="link.route"
                        :href="route(link.route)"
                        :active="route().current(link.route)"
                    >
                        {{ link.name }}
                    </ResponsiveNavLink>
                    <hr class="border-neutral-light mb-4" />
                    <ResponsiveNavLink
                        :href="route('prijava')"
                        :active="route().current('prijava')"
                        class=""
                    >
                        <div class="flex items-center">
                            <EnvelopeIcon :is-opened="route().current('prijava')" class="w-6 h-6 me-2 text-neutral-light" />
                            <span class="text-neutral-light font-medium">Prijava na akcije</span>
                        </div>
                    </ResponsiveNavLink>
                </div>
            </div>
        </Transition>
    </nav>
</template>
