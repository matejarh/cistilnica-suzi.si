<script setup>
import { ref, onMounted } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';

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
        showConsent.value = true;
    }
};

onMounted(() => {
    loadPreferences();
});
</script>

<template>
    <Transition enter-active-class="animate__animated animate__bounceInLeft" leave-active-class="animate__animated animate__bounceOutRight">
        <div v-if="showConsent" class="fixed bottom-0 left-0 right-0 bg-primary-dark text-white p-4 z-50">
            <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div class="text-sm mb-4 sm:mb-0">
                    <p>
                        Za izboljšanje vaše izkušnje na naši strani uporabljamo piškotke. Izberite, katere vrste piškotkov želite omogočiti.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div>
                        <label class="flex items-center space-x-2">
                            <Checkbox :checked="true" disabled />
                            <span>Nujni piškotki</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <Checkbox v-model:checked="consentPreferences.analytics" />
                            <span>Analitični piškotki</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <Checkbox v-model:checked="consentPreferences.marketing" />
                            <span>Marketinški piškotki</span>
                        </label>
                    </div>
                    <button @click="savePreferences" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded">
                        Shrani nastavitve
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>
