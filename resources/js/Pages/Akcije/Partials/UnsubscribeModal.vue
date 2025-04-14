<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import EnvelopeSolidIcon from '@/Icons/EnvelopeSolidIcon.vue';

const emit = defineEmits(['close']);

const show = defineProps({
    modelValue: Boolean,
});

const unsubscribeForm = useForm({
    email: '',
});

const inputClasses = computed(() => [
    unsubscribeForm.errors.email ? 'bg-red-100' : '',
]);

const submitUnsubscribe = () => {
    unsubscribeForm.post(route('subscribers.unsubscribe.confirm'), {
        preserveScroll: true,
        onSuccess: () => {
            unsubscribeForm.reset();
            emit('close');
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>

<template>
    <DialogModal :show="modelValue" @close="emit('close')">
        <template #title>
            <h2 class="text-lg font-semibold text-neutral-light">Odjava od promocij</h2>
        </template>
        <template #content>
            <p class="mb-4">Za odjavo od akcij vnesite elektronski naslov, s katerim ste se prijavili na akcije.</p>
            <p class="mb-4">Na ta elektronski naslov boste prejeli povezavo za potrditev. Povezavo morate odpreti v tem brskalniku.</p>
            <form class="space-y-4">
                <div>
                    <div class="relative w-full">
                        <label for="email" class="hidden mb-2 text-sm font-medium text-neutral-light">
                            E-poštni naslov
                        </label>
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <EnvelopeSolidIcon
                                class="w-5 h-5"
                                :class="unsubscribeForm.errors.email ? 'text-red-500' : 'text-primary'"
                            />
                        </div>
                        <input
                            v-model="unsubscribeForm.email"
                            class="block p-3 pl-10 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                            :class="inputClasses"
                            placeholder="Vnesite vaš e-poštni naslov"
                            type="email"
                            id="email"
                            required
                        />
                    </div>
                    <InputError :message="unsubscribeForm.errors.email" class="mt-2" />
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex items-center space-x-4">
                <button
                    @click="emit('close')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300"
                >
                    Prekliči
                </button>
                <button
                    @click="submitUnsubscribe"
                    :disabled="unsubscribeForm.processing"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-light disabled:opacity-50"
                >
                    <Cog8ToothIcon
                        class="w-5 h-5 mr-2 animate-spin"
                        v-show="unsubscribeForm.processing"
                    />
                    {{ unsubscribeForm.processing ? 'Pošiljam...' : 'Potrdi odjavo' }}
                </button>
            </div>
        </template>
    </DialogModal>
</template>
