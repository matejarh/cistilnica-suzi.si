<!-- filepath: resources/js/Components/SendToSubscribersConfirmationDialog.vue -->
<script setup>
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    show: Boolean,
    promotion: Object,
});

const emit = defineEmits(['close', 'clearPromotionToSend']);
const isBusy = ref(false);
// Handle sending the promotion to subscribers
const confirm = () => {
    if (props.promotion) {
        isBusy.value = true; // Set busy state
        // Perform the sending using Inertia
        router.post(route('promotions.send', props.promotion), {}, {
            preserveState: false,
            onSuccess: () => {

                emit('close');
                emit('clearPromotionToSend');
                isBusy.value = false; // Reset busy state
            },
            onFinish: () => {
                isBusy.value = false; // Reset busy state
            },
            onError: (errors) => {
                console.error(errors);
                isBusy.value = false; // Reset busy state
            },
        });
    }
};
</script>

<template>
    <ConfirmationModal :show="show" @close="$emit('close')">
        <template #title>
            Potrditev pošiljanja akcije
        </template>
        <template #content>
            Ali ste prepričani, da želite poslati akcijo "<strong>{{ promotion?.name }}</strong>" vsem naročnikom?
            Prepričajte se, da so podatki pravilni, saj bo akcija poslana takoj.
        </template>
        <template #footer>
            <button @click="$emit('close')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                Prekliči
            </button>
            <button @click="confirm" :disabled="isBusy"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 disabled:opacity-50">
                <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="isBusy" />
                {{ isBusy ? 'Pošiljam...' : 'Pošlji' }}
            </button>
        </template>
    </ConfirmationModal>
</template>
