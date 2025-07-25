<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import ActionSection from '@/Components/ActionSection.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import KeyIcon from '@/Icons/KeyIcon.vue';

defineProps({
    sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmLogout = () => {
    confirmingLogout.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const logoutOtherBrowserSessions = () => {
    form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLogout.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection>
        <template #title>
            Seje brskalnika
        </template>

        <template #description>
            Upravljajte in odjavite svoje aktivne seje v drugih brskalnikih in napravah.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-neutral-light">
                Če je potrebno, se lahko odjavite iz vseh svojih drugih sej brskalnika na vseh svojih napravah. Nekatere
                vaše nedavne seje so navedene spodaj; vendar ta seznam morda ni izčrpen. Če menite, da je bil vaš račun
                ogrožen, morate tudi posodobiti svoje geslo.
            </div>

            <!-- Druge seje brskalnika -->
            <div v-if="sessions.length > 0" class="mt-5 space-y-6">
                <div v-for="(session, i) in sessions" :key="i" class="flex items-center">
                    <div>
                        <svg v-if="session.agent.is_desktop" class="size-8 text-neutral-light"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>

                        <svg v-else class="size-8 text-neutral-light" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                    </div>

                    <div class="ms-3">
                        <div class="text-sm text-neutral-light">
                            {{ session.agent.is_desktop ? 'Namizni računalnik' : 'Mobilna naprava' }}
                            <template v-if="session.agent.is_tablet"> - Tablični računalnik</template>
                            <template v-if="session.agent.is_bot"> - Bot</template>
                            {{ session.agent.platform || 'Neznano' }} - {{ session.agent.browser || 'Neznano' }}
                        </div>

                        <div>
                            <div class="text-xs text-neutral-light">
                                {{ session.ip_address }},

                                <span v-if="session.is_current_device" class="text-green-500 font-semibold">Ta
                                    naprava</span>
                                <span v-else>Zadnja aktivnost {{ session.last_active }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center mt-5">
                <PrimaryButton @click="confirmLogout">
                    Odjava iz drugih sej brskalnika
                </PrimaryButton>

                <ActionMessage :on="form.recentlySuccessful" class="ms-3">
                    Končano.
                </ActionMessage>
            </div>

            <!-- Potrditev odjave iz drugih naprav -->
            <DialogModal :show="confirmingLogout" @close="closeModal">
                <template #title>
                    Odjava iz drugih sej brskalnika
                </template>

                <template #content>
                    Prosimo, vnesite svoje geslo, da potrdite, da se želite odjaviti iz svojih drugih sej brskalnika na
                    vseh svojih napravah.

                    <div class="mt-4">
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <KeyIcon class="w-5 h-5 "
                                    :class="form.errors.password ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <TextInput ref="passwordInput" v-model="form.password" type="password"
                                class="mt-1 block w-3/4" placeholder="Geslo" autocomplete="current-password"
                                @keyup.enter="logoutOtherBrowserSessions" />
                        </div>
                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Prekliči
                    </SecondaryButton>

                    <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="logoutOtherBrowserSessions">
                        Odjava iz drugih sej brskalnika
                    </PrimaryButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
