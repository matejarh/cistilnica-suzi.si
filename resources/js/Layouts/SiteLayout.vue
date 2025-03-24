<script setup>
import { computed, onMounted, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import CookieConsentPopup from '@/Components/CookieConsentPopup.vue';
import ScrollToTop from '@/Components/ScrollToTop.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};

const year = computed(() => new Date().getFullYear());

const createBubbles = (containerId, bubbleCount = 20) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    for (let i = 0; i < bubbleCount; i++) {
        const bubble = document.createElement("div");
        bubble.className = "bubble";

        const size = Math.random() * 60 + 20; // Random size between 20px and 80px
        bubble.style.width = `${size}px`;
        bubble.style.height = `${size}px`;
        bubble.style.left = `${Math.random() * 100}%`; // Random horizontal position
        bubble.style.bottom = `-${size}px`; // Start below the container
        bubble.style.animationDuration = `${Math.random() * 5 + 3}s`; // Random animation duration
        bubble.style.animationDelay = `${Math.random() * 2}s`; // Random animation delay

        container.appendChild(bubble);
    }
};

const scrollPosition = ref(0);

const handleScroll = (e) => {
  scrollPosition.value = e.target.scrollTop;
  // emit("scrollTop", e.target.scrollTop);
};

onMounted(() => {
    createBubbles("container");
});
</script>

<template>
    <div class="relative">

        <Head :title="title" />
        <Banner />

        <div id="container"
            class="relative h-screen text-white overflow-hidden bg-gradient-to-b from-primary to-primary-light bg-opacity-70 backdrop-blur-md">
            <nav class="bg-primary  border-b border-primary-light z-50 bg-opacity-70 backdrop-blur-md relative">
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
                                <NavLink :href="route('home')" :active="route().current('home')">
                                    Domov
                                </NavLink>
                                <NavLink :href="route('about')" :active="route().current('about')">
                                    O nas
                                </NavLink>
                                <NavLink :href="route('prices')" :active="route().current('prices')">
                                    Cenik
                                </NavLink>
                                <NavLink :href="route('contact')" :active="route().current('contact')">
                                    Kontakt
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <NavLink :href="route('prijava')" :active="route().current('prijava')">
                                Prijava na akcije
                            </NavLink>
                            <div class="ms-3 relative">
                                <!-- Teams Dropdown -->

                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">

                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-neutral-light hover:text-white hover:bg-primary-light focus:outline-none focus:bg-primary-light focus:text-white transition duration-150 ease-in-out"
                                @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path
                                        :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                    class="sm:hidden absolute right-0 z-50 w-56 mt-2 origin-top-right bg-primary  divide-y divide-primary-light  rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                            Domov
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('about')" :active="route().current('about')">
                            O nas
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('prices')" :active="route().current('prices')">
                            Cenik
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('contact')" :active="route().current('contact')">
                            Kontakt
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-primary dark:border-primary-dark">
                        <div class="flex items-center px-4">
                            <!--  <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-primary-dark dark:text-primary-light">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-primary">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div> -->
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('prijava')" :active="route().current('prijava')">
                                Prijava na akcije
                            </ResponsiveNavLink>

                            <!--                             <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink> -->

                            <!-- Authentication -->
                            <!--                             <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form> -->


                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <!--             <header v-if="$slots.header" class="bg-primary-light dark:bg-primary-dark text-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header> -->

            <!-- Page Content -->
            <main
            id="main"
            @scroll="handleScroll"
            class="overflow-y-auto h-full custom-scrollbar scroll-smooth">
                <slot />
            </main>

            <!-- Page Footer -->


            <footer class="bg-primary shadow-sm mt-4 absolute bottom-0 w-full bg-opacity-60 backdrop-blur-md">
                <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                    <span class="text-sm text-neutral-light sm:text-center ">© {{ year }} <inertia-link
                            :href="route('home')" class="hover:underline">Čistilnica Suzi</inertia-link>. Vse pravice pridržane.
                    </span>
                    <ul
                        class="flex flex-wrap items-center mt-3 text-sm font-medium text-neutral-light  sm:mt-0">
                        <li>
                            <inertia-link :href="route('about')" class="hover:underline me-4 md:me-6">O nas</inertia-link>
                        </li>
                        <li>
                            <inertia-link :href="route('prices')" class="hover:underline me-4 md:me-6">Cenik</inertia-link>
                        </li>
                        <li>
                            <inertia-link :href="route('contact')" class="hover:underline me-4 md:me-6">Kontakt</inertia-link>
                        </li>
                        <li>
                            <inertia-link :href="route('prijava')" class="hover:underline">Prijava na akcije</inertia-link>
                        </li>
                    </ul>
                </div>
            </footer>

            <ScrollToTop :scrollTop="scrollPosition" />
            <CookieConsentPopup />

        </div>
    </div>
</template>

<style>
/* #container {
    background: linear-gradient(to bottom, #0ea5e9, #7dd3fc);
    position: relative;
    overflow: hidden;
} */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: rgba(14, 165, 233, 0.5) transparent;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(14, 165, 233, 0.5);
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(14, 165, 233, 0.7);
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.bubble {
    position: absolute;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: float 6s infinite ease-in-out;
    pointer-events: none;
    /* Prevent bubbles from interfering with user interactions */
    z-index: -1;
    /* Behind all other elements */
}

@keyframes float {
    0% {
        transform: translateY(100%);
        /* Start below the container */
        opacity: 0.8;
    }

    50% {
        opacity: 1;
    }

    100% {
        transform: translateY(-100vh);
        /* Move to the top of the container */
        opacity: 0.8;
    }
}
</style>
