<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection>
        <template #title>
            Izbriši račun
        </template>

        <template #description>
            Trajno izbrišite svoj račun.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Ko je vaš račun izbrisan, bodo vsi njegovi viri in podatki trajno izbrisani. Preden izbrišete svoj račun, prenesite vse podatke ali informacije, ki jih želite obdržati.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmUserDeletion">
                    Izbriši račun
                </DangerButton>
            </div>

            <!-- Potrditveno okno za brisanje računa -->
            <DialogModal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    Izbriši račun
                </template>

                <template #content>
                    Ali ste prepričani, da želite izbrisati svoj račun? Ko je vaš račun izbrisan, bodo vsi njegovi viri in podatki trajno izbrisani. Prosimo, vnesite svoje geslo, da potrdite, da želite trajno izbrisati svoj račun.

                    <div class="mt-4">
                        <TextInput
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="Geslo"
                            autocomplete="current-password"
                            @keyup.enter="deleteUser"
                        />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Prekliči
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Izbriši račun
                    </DangerButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
