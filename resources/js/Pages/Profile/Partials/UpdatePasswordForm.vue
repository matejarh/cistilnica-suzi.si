<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import KeyIcon from '@/Icons/KeyIcon.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Posodobi geslo
        </template>

        <template #description>
            Prepričajte se, da vaš račun uporablja dolgo, naključno geslo za večjo varnost.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="current_password" value="Trenutno geslo" />
                <div class="relative w-full">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <KeyIcon class="w-5 h-5 " :class="form.errors.current_password ? 'text-red-500' : 'text-primary'" />
                    </div>
                    <TextInput
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="current-password"
                    />
                </div>
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="password" value="Novo geslo" />
                                <div class="relative w-full">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <KeyIcon class="w-5 h-5 " :class="form.errors.password ? 'text-red-500' : 'text-primary'" />
                    </div>
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />
                </div>
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="password_confirmation" value="Potrdite geslo" />
                                <div class="relative w-full">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <KeyIcon class="w-5 h-5 " :class="form.errors.password_confirmation ? 'text-red-500' : 'text-primary'" />
                    </div>
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />
                </div>
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Shranjeno.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Shrani
            </PrimaryButton>
        </template>
    </FormSection>
</template>
