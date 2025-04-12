<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import EnvelopeSolidIcon from '@/Icons/EnvelopeSolidIcon.vue';
import UserIcon from '@/Icons/UserIcon.vue';
import CompanyIcon from '@/Icons/CompanyIcon.vue';
import AtSymbolIcon from '@/Icons/AtSymbolIcon.vue';
import PhoneIcon from '@/Icons/PhoneIcon.vue';
import MapPinIcon from '@/Icons/MapPinIcon.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import MegaphoneIcon from '@/Icons/MegaphoneIcon.vue';

const form = useForm({
    name: '',
    company: '',
    phone: '',
    address: '',
    email: '',
    subject: '',
    message: '',
});

const submitForm = () => {
    form.post(route('inquiries.confirm'), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <section id="povpraševanje" class="py-12 bg-neutral-dark/40 backdrop-blur-xs">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-primary-dark dark:text-primary-light text-center">
                Pošljite nam povpraševanje
            </h2>
            <p class="mt-4 text-lg text-neutral-dark dark:text-neutral-light text-center">
                Izpolnite spodnji obrazec in kontaktirali vas bomo v najkrajšem možnem času.
            </p>

            <form @submit.prevent="submitForm" class="mt-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ime  -->
                    <div class="relative w-full">
                        <InputLabel for="name" value="Ime in priimek" />
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <UserIcon class="w-5 h-5 "
                                    :class="form.errors.name ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <TextInput required id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                                placeholder="Vaše ime in priimek" :has-error="!!form.errors.name" />
                        </div>
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <!-- Podjetje  -->
                    <div>
                        <InputLabel for="company" value="Podjetje (izbirno)" />
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <CompanyIcon class="w-5 h-5 "
                                    :class="form.errors.company ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <TextInput id="company" v-model="form.company" type="text" class="mt-1 block w-full"
                                placeholder="Vaše podjetje" :has-error="!!form.errors.company" />
                        </div>
                        <InputError :message="form.errors.company" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <InputLabel for="email" value="Elektronski naslov" />
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <AtSymbolIcon class="w-5 h-5 "
                                    :class="form.errors.email ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <TextInput required id="email" v-model="form.email" type="email" class="mt-1 block w-full"
                                placeholder="Vaš elektronski naslov" :has-error="!!form.errors.email" />
                        </div>
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>

                    <!-- Telefon -->
                    <div>
                        <InputLabel for="phone" value="Telefonska številka" />
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <PhoneIcon class="w-5 h-5 "
                                    :class="form.errors.phone ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <TextInput required id="phone" v-model="form.phone" type="tel" class="mt-1 block w-full"
                                placeholder="Vaša telefonska številka" :has-error="!!form.errors.phone" />
                        </div>
                        <InputError :message="form.errors.phone" class="mt-2" />
                    </div>

                    <!-- Naslov -->
                    <div class="md:col-span-2">
                        <InputLabel for="address" value="Naslov" />
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <MapPinIcon class="w-5 h-5 "
                                    :class="form.errors.address ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <TextInput id="address" v-model="form.address" type="text" class="mt-1 block w-full"
                                placeholder="Vaš naslov" :has-error="!!form.errors.address" />
                        </div>
                        <InputError :message="form.errors.address" class="mt-2" />
                    </div>
                </div>


                <!-- Zadeva -->
                <div >
                    <InputLabel for="subject" value="Zadeva" />
                    <div class="relative w-full">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <MegaphoneIcon class="w-5 h-5 "
                                :class="form.errors.subject ? 'text-red-500' : 'text-primary'" />
                        </div>
                        <TextInput id="subject" v-model="form.subject" type="text" class="mt-1 block w-full"
                            placeholder="Vnesite zadevo" :has-error="!!form.errors.subject" />
                    </div>
                    <InputError :message="form.errors.subject" class="mt-2" />
                </div>
                <!-- Besedilo povpraševanja -->
                <div>
                    <InputLabel for="message" value="Besedilo povpraševanja" />
                    <textarea id="message" v-model="form.message" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:ring-primary focus:border-primary sm:text-sm"
                        :class="form.errors.message ? 'bg-red-100 border-red-500 text-red-900 placeholder-red-500 focus:ring-red-500 focus:border-red-500' : 'bg-neutral-light border-neutral-light text-neutral-dark placeholder-neutral-dark'"
                        placeholder="Vaše povpraševanje"></textarea>
                    <InputError :message="form.errors.message" class="mt-2" />
                </div>

                <!-- Gumb za pošiljanje -->
                <div class="flex justify-end">
                    <ButtonPrimary as="button" :disabled="form.processing || !form.isDirty" @click="submitForm">
                        <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="form.processing" />
                        {{ form.processing ? 'Pošiljanje...' : 'Pošlji povpraševanje' }}

                    </ButtonPrimary>
                </div>

                <!-- Uspešno sporočilo -->
                <p v-if="form.recentlySuccessful" class="mt-4 text-sm text-green-600 text-center">
                    Vaše povpraševanje je bilo uspešno poslano. Hvala!
                </p>
            </form>
        </div>
    </section>
</template>
