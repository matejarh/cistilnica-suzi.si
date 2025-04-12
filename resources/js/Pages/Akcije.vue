<script setup>
import { ref, computed } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';

import SiteLayout from '@/Layouts/SiteLayout.vue';
import SubscribeSection from '@/Components/SubscribeSection.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';

import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import EnvelopeSolidIcon from '@/Icons/EnvelopeSolidIcon.vue';

// Page props
const { auth, promotions } = usePage().props;
const user = ref(auth?.user || null);

// Modal state
const showUnsubscribeModal = ref(false);

// Unsubscribe form
const unsubscribeForm = useForm({
    email: '',
});

// Dynamic input classes
const inputClasses = computed(() => [
    unsubscribeForm.errors.email ? 'bg-red-100' : '',
]);

// Submit unsubscribe form
const submitUnsubscribe = () => {
    unsubscribeForm.post(route('subscribers.unsubscribe.confirm'), {
        preserveScroll: true,
        onSuccess: () => {
            unsubscribeForm.reset();
            showUnsubscribeModal.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>

<template>
    <SiteLayout
        title="Prijava na promocije in akcije"
        description="Prijavite se na promocije in akcije Čistilnice Suzi"
        keywords="akcije, promocije, čistilnica, suzi, prijava"
    >
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
                <!-- Banner Section -->
                <div class="bg-primary overflow-hidden shadow-xl shadow-primary sm:rounded-lg bg-opacity-60 backdrop-blur-sm">
                    <div class="p-6 lg:p-8 flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                        <div class="flex-1">
                            <h1 class="font-heading text-4xl font-bold text-neutral-light">
                                Prijava na promocije in akcije
                            </h1>
                            <p class="font-sans text-lg text-neutral-light mt-4">
                                Prijavite se na naše promocije in akcije ter bodite obveščeni o najnovejših ponudbah in ugodnostih.
                            </p>
                        </div>
                        <div class="flex-1">
                            <img
                                src="@images/prijava_na_akcije.png"
                                alt="Prijava na akcije"
                                class="rounded-lg"
                            />
                        </div>
                    </div>
                </div>

                <!-- Subscribe Section -->
                <SubscribeSection class="rounded-lg" />

                <!-- Links Section -->
                <div class="bg-primary overflow-hidden shadow-xl shadow-primary sm:rounded-lg bg-opacity-60 backdrop-blur-sm p-6 lg:p-8 space-y-4">
                    <h2 class="font-heading text-2xl font-bold text-neutral-light">Upravljanje z akcijami</h2>
                    <ul class="text-neutral-light">
                        <li>
                            <button @click="showUnsubscribeModal = true" class="text-white hover:underline">
                                Odjava od akcij
                            </button>
                        </li>
                        <li v-if="user">
                            <a :href="route('promotions.index')" class="text-white hover:underline">
                                Uredi akcije
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Unsubscribe Modal -->
        <DialogModal :show="showUnsubscribeModal" @close="showUnsubscribeModal = false">
            <template #header>
                <h2 class="text-lg font-semibold text-neutral-light">Odjava od promocij</h2>
            </template>
            <template #content>
                <form @submit.prevent="submitUnsubscribe" class="space-y-4">
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
                                ref="emailInput"
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
                        @click="showUnsubscribeModal = false"
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
    </SiteLayout>
</template>
