<template>
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-primary to-primary-light text-white overflow-hidden">
        <!-- Bubbles -->
        <div id="bubble-container" class="absolute inset-0 overflow-hidden z-10"></div>

        <!-- Logo Slot -->
        <div class="z-20">
            <slot name="logo" />
        </div>

        <!-- Card Content -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-primary bg-opacity-75 backdrop-blur-sm  shadow-md overflow-hidden sm:rounded-lg z-20">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

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

    const bubbleCount = getBubbleCount(); // Adjust the number of bubbles

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

const handleResize = () => {
    createBubbles("bubble-container"); // Recreate bubbles on screen resize
};

onMounted(() => {
    createBubbles("bubble-container"); // Initial bubble creation
    window.addEventListener("resize", handleResize); // Listen for resize events
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize); // Clean up event listener
});
</script>

<style>
.bubble {
    position: absolute;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.3));
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    border-radius: 50%;
    animation: float 6s infinite ease-in-out;
    pointer-events: none;
    z-index: -1;
}

@keyframes float {
    0% {
        transform: translateY(100%);
        opacity: 0.5;
    }
    50% {
        opacity: 0.8;
    }
    100% {
        transform: translateY(-100vh);
        opacity: 0.5;
    }
}
</style>
