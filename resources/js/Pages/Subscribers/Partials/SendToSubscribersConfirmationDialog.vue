<!-- filepath: resources/js/Components/SendToSubscribersConfirmationDialog.vue -->
<script setup>
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DialogModal from '@/Components/DialogModal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    show: Boolean,
    subscriber: Object,
    onClose: Function,
});

const emit = defineEmits(['close', 'clearCurrentSubscriber']);
const isBusy = ref(false);

const form = useForm({
    message: '',
});

const send = () => {
    if (props.subscriber) {

        // Perform the sending using Inertia
        form.put(route('subscribers.send', props.subscriber), {

            onSuccess: () => {
                emit('close');
                emit('clearCurrentSubscriber');
                form.reset();

            },
            onFinish: () => {

            },
            onError: (errors) => {
                console.error(errors);
            },
        });
    }
};
</script>

<template>
    <DialogModal :show="show" @close="onClose" max-width="xl">
        <template #title>
            <h2 class="text-lg font-semibold text-neutral-light">
                Pošlji sporočilo na {{ subscriber?.email }}
            </h2>
        </template>
        <template #content>
            Ali ste prepričani, da želite poslati sporočilo na naročnika "<strong>{{ subscriber?.email }}</strong>"?
            Prepričajte se, da so podatki pravilni, saj bo sporočilo poslano takoj.

            <form class="space-y-4 mt-4">
                <div>
                    <InputLabel for="message" value="Sporočilo" class="mb-2" />
                    <textarea
                        id="message"
                        v-model="form.message"
                        type="text"
                        rows="5"
                        required
                        class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                        :class="{
                            'border-red-500 bg-red-50': form.errors.message,
                        }"
                        placeholder="Vnesite sporočilo"
                    />
                    <InputError :message="form.errors.message" class="mt-2" />
                </div>
            </form>


        </template>
        <template #footer>
            <button @click="$emit('close')"
                class="px-4 py-2 me-4 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                Prekliči
            </button>
            <button @click="send" :disabled="form.processing"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 disabled:opacity-50">
                <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="form.processing" />
                {{ form.processing ? 'Pošiljam...' : 'Pošlji' }}
            </button>
        </template>
    </DialogModal>
</template>
