<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    show: Boolean,
    isEditMode: Boolean,
    onClose: Function,
});

// Emit events for parent component
const emit = defineEmits(['submit', 'close',]);

// Initialize form
// The form is initialized with empty values
// and will be populated when the dialog is opened
const form = useForm({
    email: '',
});

const handleSubmit = () => {
    form.post(route('subscribers.store.admin'), {
        onSuccess: () => {
            emit('close');
            form.reset();
        },
        onError: () => {
            // Handle error
        },
    });
};

const handleCancel = () => {
    emit('close');
    form.reset();
};
</script>

<template>
    <DialogModal :show="show" @close="onClose" max-width="xl">
        <template #title>
            <h2 class="text-lg font-semibold text-neutral-light">
                Dodaj naročnika
            </h2>
        </template>
        <template #content>
            <form class="space-y-4">
                <div>
                    <InputLabel for="email" value="Naslov" class="mb-2" />
                    <input
                        id="email"
                        v-model="form.email"
                        type="text"
                        required
                        class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                        :class="{
                            'border-red-500': form.errors.email,
                        }"
                        placeholder="Vnesite spletni naslov naročnika"
                    />
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex items-center space-x-4">
                <button @click="handleCancel" class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                    Prekliči
                </button>
                <button
                    @click="handleSubmit"
                    :disabled="form.processing"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-light disabled:opacity-50"
                >
                    <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="form.processing" />
                    {{ form.processing ? 'Shranjujem...' : 'Shrani' }}
                </button>
            </div>
        </template>
    </DialogModal>
</template>
