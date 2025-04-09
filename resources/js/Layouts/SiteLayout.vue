<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import CookieConsentPopup from '@/Components/CookieConsentPopup.vue';
import ScrollToTop from '@/Components/ScrollToTop.vue';
import Footer from './Footer.vue';
import Navigation from './Navigation.vue';

defineProps({
    title: String,
    description: {
        type: String,
        default: 'Čistilnica Suzi - brezhibna čistoča za vaše perilo',
    },
    keywords: {
        type: String,
        default: 'čistilnica, suzi, brezhibna, čistoča, perilo, pranje, kemično čiščenje',
    },
});

/* const logout = () => {
    router.post(route('logout'));
}; */

const year = computed(() => new Date().getFullYear());

const getBubbleCount = () => {
    const width = window.innerWidth;
    // Adjust bubble count based on screen width
    if (width >= 1600) return 30; // Extra large screens
    if (width >= 1200) return 20; // Large screens
    if (width >= 768) return 10; // Medium screens
    return 5; // Small screens
};

const createBubbles = (containerId) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    // Clear all existing bubbles
    const existingBubbles = container.getElementsByClassName("bubble");
    while (existingBubbles.length > 0) {
        existingBubbles[0].remove();
    }

    const bubbleCount = getBubbleCount(); // Get bubble count based on screen width

    for (let i = 0; i < bubbleCount; i++) {
        const bubble = document.createElement("div");
        bubble.className = "bubble";

        const size = Math.random() * 80 + 20; // Random size between 20px and 80px
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
const handleResize = () => {
    createBubbles("container"); // Recreate bubbles on screen resize
};

onMounted(() => {
    createBubbles("container"); // Initial bubble creation
    window.addEventListener("resize", handleResize); // Listen for resize events
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize); // Clean up event listener
});
</script>

<template>
    <div class="relative">

        <Head :title="title" >
            <meta name="description" :content="description" />
            <meta name="keywords" :content="keywords" />
            <meta name="author" content="Web3 Solutions" />
        </Head>
        <Banner />

        <div id="container"
            class="relative h-screen text-white overflow-hidden bg-gradient-to-b from-primary to-primary-light bg-opacity-70 backdrop-blur-md">
            <Navigation />

            <!-- Page Heading -->
            <!-- <header v-if="$slots.header" class="bg-primary text-white z-40 bg-opacity-70 backdrop-blur-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 font-heading">
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
            <Footer />

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
    background: radial-gradient(circle, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.3));
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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
        opacity: 0.5;
    }

    50% {
        opacity: 0.8;
    }

    100% {
        transform: translateY(-100vh);
        /* Move to the top of the container */
        opacity: 0.5;
    }
}
</style>
