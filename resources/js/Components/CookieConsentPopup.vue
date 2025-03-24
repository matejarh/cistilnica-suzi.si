<script setup>
import { ref, onMounted } from 'vue';

const showConsent = ref(false);

const acceptCookies = () => {
    showConsent.value = false;
    localStorage.setItem('cookieConsent', 'true');
};

if (localStorage.getItem('cookieConsent') !== 'true') {
    onMounted(() => {
        setTimeout(() => {
            showConsent.value = true;
        }, 1000);
    });
}
</script>

<template>
    <Transition enter-active-class="animate__animated animate__bounceInLeft" leave-active-class="animate__animated animate__bounceOutRight">
        <div v-if="showConsent" class="fixed bottom-0 left-0 right-0 bg-primary-dark text-white p-4 z-50">
            <div class="max-w-screen-xl  mx-auto flex justify-between items-center">
                <p class="text-sm">
                    Za izboljšanje vaše izkušnje na naši strani uporabljamo piškotke. Z uporabo naše strani se strinjate z uporabo piškotkov.
                </p>
                <button @click="acceptCookies" class="bg-primary-700 hover:bg-primary-800 text-white font-bold py-2 px-4 rounded">
                    Sprejmi
                </button>
            </div>
        </div>
    </Transition>
</template>
