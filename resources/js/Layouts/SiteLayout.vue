<script setup>
import { onMounted, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};

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

onMounted(() => {
    createBubbles("container");
});
</script>

<template>
    <div class="relative">
        <Head :title="title" />
        <Banner />

        <div
            id="container"
            class="relative h-screen flex items-center justify-center text-white px-4 sm:px-6 lg:px-8 overflow-hidden bg-gradient-to-b from-primary to-primary-light"
        >

            <div class="text-center max-w-md sm:max-w-lg lg:max-w-2xl w-full z-10">
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold leading-tight">
                    Dobrodošli v Čistilnici Suzi
                </h1>
                <p class="mt-4 text-sm sm:text-base lg:text-lg">
                    Bleščeče čisto, sveže in okolju prijazno
                </p>
                <button
                    class="mt-6 px-4 py-2 sm:px-6 sm:py-3 bg-white text-primary font-semibold rounded-lg shadow-lg hover:bg-neutral-light transition duration-300"
                >
                    Prijavite se za ponudbe
                </button>
            </div>
        </div>
    </div>
</template>

<style>
#container {
    position: relative;
    overflow: hidden; /* Ensure bubbles stay within the container */
}

.bubble {
    position: absolute;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: float 6s infinite ease-in-out;
    pointer-events: none; /* Prevent bubbles from interfering with user interactions */
}

@keyframes float {
    0% {
        transform: translateY(100%); /* Start below the container */
        opacity: 0.8;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh); /* Move to the top of the container */
        opacity: 0.8;
    }
}
</style>
