<script setup>
import { ref, reactive, nextTick } from 'vue';
import DialogModal from './DialogModal.vue';
import InputError from './InputError.vue';
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';
import TextInput from './TextInput.vue';
import KeyIcon from '@/Icons/KeyIcon.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';

const emit = defineEmits(['confirmed']);

defineProps({
    title: {
        type: String,
        default: 'Potrdite geslo',
    },
    content: {
        type: String,
        default: 'Zaradi varnostvenih razlogov morate potrditi geslo, preden nadaljujete.',
    },
    button: {
        type: String,
        default: 'Potrdi',
    },
});

const confirmingPassword = ref(false);

const form = reactive({
    password: '',
    error: '',
    processing: false,
});

const passwordInput = ref(null);

const startConfirmingPassword = () => {
    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');
        } else {
            confirmingPassword.value = true;

            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;

        closeModal();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        passwordInput.value.focus();
    });
};

const closeModal = () => {
    confirmingPassword.value = false;
    form.password = '';
    form.error = '';
};
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <DialogModal :show="confirmingPassword" @close="closeModal">
            <template #title>
                {{ title }}
            </template>

            <template #content>
                {{ content }}

                <div class="mt-4">
                    <div class="relative w-full">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <KeyIcon class="w-5 h-5 " :class="form.error ? 'text-red-500' : 'text-primary'" />
                        </div>
                        <TextInput ref="passwordInput" v-model="form.password" type="password" class="mt-1 block w-3/4"
                            placeholder="Vaše geslo" autocomplete="current-password" @keyup.enter="confirmPassword" />
                    </div>
                    <InputError :message="form.error" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal">
                    Prekliči
                </SecondaryButton>

                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="confirmPassword">
                    <Cog8ToothIcon class="w-5 h-5 me-2 animate-spin" v-show="form.processing" />
                    {{ button }}
                </PrimaryButton>
            </template>
        </DialogModal>
    </span>
</template>
