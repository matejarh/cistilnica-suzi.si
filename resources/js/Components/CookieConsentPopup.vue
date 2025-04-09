<script setup>
import { ref, onMounted } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';
import CookieIcon from '@/Icons/CookieIcon.vue';

const showConsent = ref(false);
const consentPreferences = ref({
    necessary: true, // Always enabled
    analytics: false,
    marketing: false,
});

const savePreferences = () => {
    localStorage.setItem('cookieConsent', JSON.stringify(consentPreferences.value));
    showConsent.value = false;
};

const loadPreferences = () => {
    const savedPreferences = localStorage.getItem('cookieConsent');
    if (savedPreferences) {
        consentPreferences.value = JSON.parse(savedPreferences);
    } else {
        setTimeout(() => {
            showConsent.value = true;
        }, 3000); // Show consent popup after 3 seconds if no preferences are saved

    }
};

onMounted(() => {
    loadPreferences();
});
</script>

<template>
    <Transition enter-active-class="animate__bounceInLeft" leave-active-class="animate__bounceOutRight">
        <div v-if="showConsent" class="fixed bottom-0 left-0 right-0 bg-primary-dark text-white p-4 z-50">
            <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div class="text-sm mb-4 sm:mb-0 flex items-center">
                    <CookieIcon class="h-24 w-24 md:h-12 md:w-12 mr-2" />
                    <p>
                        Za izboljšanje vaše izkušnje na naši strani uporabljamo piškotke. Izberite, katere vrste
                        piškotkov želite omogočiti.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 text-sm">
                    <div>
                        <label class="flex items-center space-x-2">
                            <Checkbox :checked="true" disabled />
                            <span>Nujni</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <Checkbox v-model:checked="consentPreferences.analytics" />
                            <span>Analitični</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <Checkbox v-model:checked="consentPreferences.marketing" />
                            <span>Marketinški</span>
                        </label>
                    </div>
                    <button @click="savePreferences"
                        class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded">
                        Shrani nastavitve
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
@keyframes bounceInLeft {
    0% {
        opacity: 0;
        transform: translateX(-100%);
    }

    60% {
        opacity: 1;
        transform: translateX(25%);
    }

    80% {
        transform: translateX(-10%);
    }

    100% {
        transform: translateX(0);
    }
}

@keyframes bounceOutRight {
    20% {
        opacity: 1;
        transform: translateX(-10%);
    }

    100% {
        opacity: 0;
        transform: translateX(100%);
    }
}

.animate__bounceInLeft {
    animation-name: bounceInLeft;
    animation-duration: 1s;
    animation-fill-mode: both;
}

.animate__bounceOutRight {
    animation-name: bounceOutRight;
    animation-duration: 1s;
    animation-fill-mode: both;
}
</style>
