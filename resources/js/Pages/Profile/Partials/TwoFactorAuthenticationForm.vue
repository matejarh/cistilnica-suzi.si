<script setup>
import { ref, computed, watch } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import ConfirmsPassword from '@/Components/ConfirmsPassword.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import QrCodeIcon from '@/Icons/QrCodeIcon.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';

const props = defineProps({
    requiresConfirmation: Boolean,
});

const page = usePage();
const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({
    code: '',
});

const twoFactorEnabled = computed(
    () => !enabling.value && page.props.auth.user?.two_factor_enabled,
);

watch(twoFactorEnabled, () => {
    if (!twoFactorEnabled.value) {
        confirmationForm.reset();
        confirmationForm.clearErrors();
    }
});

const enableTwoFactorAuthentication = () => {
    enabling.value = true;

    router.post(route('two-factor.enable'), {}, {
        preserveScroll: true,
        onSuccess: () => Promise.all([
            showQrCode(),
            showSetupKey(),
            showRecoveryCodes(),
        ]),
        onFinish: () => {
            enabling.value = false;
            confirming.value = props.requiresConfirmation;
        },
    });
};

const showQrCode = () => {
    return axios.get(route('two-factor.qr-code')).then(response => {
        qrCode.value = response.data.svg;
    });
};

const showSetupKey = () => {
    return axios.get(route('two-factor.secret-key')).then(response => {
        setupKey.value = response.data.secretKey;
    });
}

const showRecoveryCodes = () => {
    return axios.get(route('two-factor.recovery-codes')).then(response => {
        recoveryCodes.value = response.data;
    });
};

const confirmTwoFactorAuthentication = () => {
    confirmationForm.post(route('two-factor.confirm'), {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false;
            qrCode.value = null;
            setupKey.value = null;
        },
    });
};

const regenerateRecoveryCodes = () => {
    axios
        .post(route('two-factor.recovery-codes'))
        .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
    disabling.value = true;

    router.delete(route('two-factor.disable'), {
        preserveScroll: true,
        onSuccess: () => {
            disabling.value = false;
            confirming.value = false;
        },
    });
};
</script>

<template>
    <ActionSection>
        <template #title>
            Dvostopenjska avtentikacija
        </template>

        <template #description>
            Dodajte dodatno varnost svojemu računu z uporabo dvostopenjske avtentikacije.
        </template>

        <template #content>
            <h3 v-if="twoFactorEnabled && !confirming" class="text-lg font-medium text-neutral-light">
                Omogočili ste dvostopenjsko avtentikacijo.
            </h3>

            <h3 v-else-if="twoFactorEnabled && confirming" class="text-lg font-medium text-neutral-light">
                Dokončajte omogočanje dvostopenjske avtentikacije.
            </h3>

            <h3 v-else class="text-lg font-medium text-neutral-light">
                Dvostopenjska avtentikacija ni omogočena.
            </h3>

            <div class="mt-3 max-w-xl text-sm text-neutral-light">
                <p>
                    Ko je Dvostopenjska avtentikacija omogočena, boste med prijavo pozvani k vnosu varne, naključne
                    kode. To kodo lahko pridobite iz aplikacije Google Authenticator na svojem telefonu.
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl text-sm text-neutral-light">
                        <p v-if="confirming" class="font-semibold">
                            Za dokončanje omogočanja dvostopenjske avtentikacije skenirajte spodnjo QR kodo z aplikacijo
                            za avtentikacijo na svojem telefonu ali vnesite nastavitveni ključ in zagotovite generirano
                            OTP (one-time-password) kodo.
                        </p>

                        <p v-else>
                            Dvostopenjska avtentikacija je zdaj omogočena. Skenirajte spodnjo QR kodo z aplikacijo za
                            avtentikacijo na svojem telefonu ali vnesite nastavitveni ključ.
                        </p>
                    </div>

                    <div class="mt-4 p-2 inline-block bg-white" v-html="qrCode" />

                    <div v-if="setupKey" class="mt-4 max-w-xl text-sm text-neutral-light">
                        <p class="font-semibold">
                            Nastavitveni ključ: <span v-html="setupKey"></span>
                        </p>
                    </div>

                    <div v-if="confirming" class="mt-4">
                        <InputLabel for="code" value="Koda" />
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <QrCodeIcon class="w-4 h-4 "
                                    :class="confirmationForm.errors.code ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <TextInput id="code" v-model="confirmationForm.code" type="text" name="code"
                                class="block mt-1 w-1/2" inputmode="numeric" autocomplete="one-time-code"
                                @keyup.enter="confirmTwoFactorAuthentication"
                                :has-error="!!confirmationForm.errors.code" />
                        </div>

                        <InputError :message="confirmationForm.errors.code" class="mt-2" />
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0 && !confirming">
                    <div class="mt-4 max-w-xl text-sm text-neutral-light">
                        <p class="font-semibold">
                            Shranite te obnovitvene kode v varen upravitelj gesel. Uporabite jih lahko za obnovitev
                            dostopa do svojega računa, če izgubite napravo za dvostopenjsko avtentikacijo.
                        </p>
                    </div>

                    <div
                        class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div v-if="!twoFactorEnabled">
                    <ConfirmsPassword @confirmed="enableTwoFactorAuthentication">
                        <PrimaryButton type="button" :class="{ 'opacity-25': enabling }" :disabled="enabling">
                            <Cog8ToothIcon class="w-4 h-4 me-2 animate-spin" v-show="enabling" />
                            {{ enabling ? 'Omogočam...' : 'Omogoči' }}
                        </PrimaryButton>
                    </ConfirmsPassword>
                </div>

                <div v-else>
                    <ConfirmsPassword @confirmed="confirmTwoFactorAuthentication">
                        <PrimaryButton v-if="confirming" type="button" class="me-3" :class="{ 'opacity-25': confirmationForm.processing }"
                            :disabled="confirmationForm.processing">
                            <Cog8ToothIcon class="w-4 h-4 me-2 animate-spin" v-show="confirmationForm.processing" />
                            {{ confirmationForm.processing ? 'Potrjujem...' : 'Potrdi' }}

                        </PrimaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="regenerateRecoveryCodes">
                        <SecondaryButton v-if="recoveryCodes.length > 0 && !confirming" class="me-3">
                            <Cog8ToothIcon class="w-4 h-4 me-2 animate-spin" v-show="confirming" />
                            {{ confirming ? 'Ustvarjam obnovitvene kode...' : 'Znova ustvari obnovitvene kode' }}
                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="showRecoveryCodes">
                        <SecondaryButton v-if="recoveryCodes.length === 0 && !confirming" class="me-3">
                            <Cog8ToothIcon class="w-4 h-4 me-2 animate-spin" v-show="confirming" />
                            {{ confirming ? 'Prikazujem obnovitvene kode...' : 'Prikaži obnovitvene kode' }}

                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <SecondaryButton v-if="confirming" :class="{ 'opacity-25': disabling }" :disabled="disabling">
                            <Cog8ToothIcon class="w-4 h-4 me-2 animate-spin" v-show="disabling" />
                            {{ disabling ? 'Preklicujem...' : 'Prekliči' }}

                        </SecondaryButton>
                    </ConfirmsPassword>

                    <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <DangerButton v-if="!confirming" :class="{ 'opacity-25': disabling }" :disabled="disabling">
                            <Cog8ToothIcon class="w-4 h-4 me-2 animate-spin" v-show="disabling" />
                            {{ disabling ? 'Onemogočam...' : 'Onemogoči' }}

                        </DangerButton>
                    </ConfirmsPassword>
                </div>
            </div>
        </template>
    </ActionSection>
</template>
