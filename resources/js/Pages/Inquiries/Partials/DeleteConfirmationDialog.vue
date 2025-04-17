<!-- filepath: resources/js/Components/DeleteConfirmationDialog.vue -->
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';

const props = defineProps({
    show: Boolean,
    inquiry: Object,
});

const isBusy = ref(false);

const emit = defineEmits(['close', 'clearInquiryToDelete']);

// Handle deletion of the inquiry
const confirmDelete = () => {
    if (props.inquiry) {
        isBusy.value = true; // Set busy state
        // Perform the deletion using Inertia
        router.delete(route('inquiries.destroy', props.inquiry), {
            onSuccess: () => {
                emit('close');
                emit('clearInquiryToDelete');
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
            Potrditev izbrisa
        </template>
        <template #content>
            Ali ste prepričani, da želite izbrisati poizvedbo od "<strong>{{ inquiry?.name }}</strong>" z zadevo <b>{{ inquiry?.subject }}</b>?<br>
            To dejanje je nepovratno.
        </template>
        <template #footer>
            <button @click="$emit('close')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                Prekliči
            </button>
            <button @click="confirmDelete" :disabled="isBusy"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 disabled:opacity-50">
                <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="isBusy" />
                {{ isBusy ? 'Brišem...' : 'Izbriši' }}
            </button>
        </template>
    </ConfirmationModal>
</template>
