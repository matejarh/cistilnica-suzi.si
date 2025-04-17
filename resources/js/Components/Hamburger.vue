<script setup>
import { ref } from "vue";

defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["toggle"]);

function toggleMenu() {
    emit("toggle");
}
</script>

<template>
    <button
        id="hamburger"
        class="menu-ui rounded-lg"
        :class="{ 'is-open': isOpen }"
        @click="toggleMenu"
    >
        <svg class="size-8" stroke="currentColor" fill="none" width="30" height="30"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
            <path stroke-width="2" d="M4 8 L26 8"></path>
            <path stroke-width="2" d="M4 15 L26 15"></path>
            <path stroke-width="2" d="M4 22 L26 22"></path>
        </svg>
    </button>
</template>

<style scoped>
button {
    margin: 0;
    padding: 0;
    border: none;
    background: transparent;
}

svg {
    /* border: 1px solid white; */
    fill: currentColor;
    stroke: currentColor;
    color: white;
/*     width: 120px;
    height: 120px; */
}

/*
 * Hamburger lines reset animation, i.e. menu closed
 */
#hamburger svg path {
    transform-origin: 50% 8px;
    transition: stroke 0.3s ease-in-out, fill 0.3s ease-in-out;
}
#hamburger svg path:nth-of-type(1) {
    animation: hamburgerTopReset 300ms ease-in-out forwards;
}
#hamburger svg path:nth-of-type(2) {
    transform-origin: 50% 15px;
    animation: hamburgerMiddleReset 300ms ease-in-out forwards;
}
#hamburger svg path:nth-of-type(3) {
    transform-origin: 50% 22px;
    animation: hamburgerBottomReset 300ms ease-in-out forwards;
}

/*
 * Hamburger turns into X, i.e. menu open
 */
#hamburger.is-open svg path:nth-of-type(1) {
    animation: hamburgerTopDeform 300ms ease-in-out forwards;
}
#hamburger.is-open svg path:nth-of-type(2) {
    animation: hamburgerMiddleDeform 300ms ease-in-out forwards;
}
#hamburger.is-open svg path:nth-of-type(3) {
    animation: hamburgerBottomDeform 300ms ease-in-out forwards;
}

@keyframes hamburgerTopReset {
    0% {
        transform: translateY(7px) rotate(45deg);
    }
    50% {
        transform: translateY(7px) rotate(0deg);
    }
    100% {
        transform: translateY(0) rotate(0deg);
    }
}

@keyframes hamburgerMiddleReset {
    0% {
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        opacity: 1;
    }
}

@keyframes hamburgerBottomReset {
    0% {
        transform: translateY(-7px) rotate(-45deg);
    }
    50% {
        transform: translateY(-7px) rotate(0deg);
    }
    100% {
        transform: translateY(0) rotate(0deg);
    }
}

@keyframes hamburgerTopDeform {
    0% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(7px) rotate(0deg);
    }
    100% {
        transform: translateY(7px) rotate(45deg);
    }
}

@keyframes hamburgerMiddleDeform {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}

@keyframes hamburgerBottomDeform {
    0% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-7px) rotate(0deg);
    }
    100% {
        transform: translateY(-7px) rotate(-45deg);
    }
}
</style>
