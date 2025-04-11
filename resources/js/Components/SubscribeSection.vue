<script setup>
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import EnvelopeSolidIcon from '@/Icons/EnvelopeSolidIcon.vue';
import ExclamationIcon from '@/Icons/ExclamationIcon.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const emailInput = ref(null);

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('subscribers.confirm'), {
        preserveScroll: true,
        preserveState: true,
        onStart: () => {
            form.clearErrors();
        },
        onFinish: () => {
            // form.reset();
        },
        onSuccess: (response) => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
            if (errors.email) {
                emailInput.value.select();
            }
        },
    });
};

const inputClasses = computed(() => {
    return [
        form.errors.email ? 'bg-red-100' : '',

    ];

});

</script>

<template>
    <section class="bg-primary-dark text-neutral-light bg-opacity-40 backdrop-blur-sm">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-md text-center">
                <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-primary-light sm:text-4xl">
                    Prijavite se na naše akcije
                </h2>
                <p class="mx-auto mb-8 max-w-2xl font-light text-neutral-light sm:text-xl">
                    Bodite na tekočem z našimi storitvami, posebnimi ponudbami in novostmi. Prijavite se z vašim
                    e-poštnim naslovom.
                </p>
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                        <div class="relative w-full">
                            <label for="email" class="hidden mb-2 text-sm font-medium text-neutral-light">
                                E-poštni naslov
                            </label>
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <EnvelopeSolidIcon class="w-5 h-5 "
                                    :class="form.errors.email ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <input ref="emailInput" v-model="form.email"
                                class="block p-3 pl-10 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light sm:rounded-none sm:rounded-l-lg"
                                :class="inputClasses" placeholder="Vnesite vaš e-poštni naslov" type="email" id="email"
                                required>
                        </div>

                        <div>
                            <button type="submit"
                                :disabled="form.processing || !form.isDirty"
                                class="flex items-center whitespace-nowrap py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary hover:bg-primary-light   sm:rounded-none sm:rounded-r-lg disabled:opacity-50 transition ease-in-out duration-150">
                                <Cog8ToothIcon class="w-4 h-4 mr-2 animate-spin" v-show="form.processing" />
                                {{ form.processing ? 'Prijavljam...' : 'Prijavi se' }}
                            </button>
                        </div>
                    </div>
                    <span v-if="form.errors.email"
                        class="text-sm text-red-500 bg-white rounded-lg px-2 py-1 flex items-center">
                        <ExclamationIcon class="w-5 h-5 text-red-500 mr-2" />

                        {{ form.errors.email }}
                    </span>
                    <!-- <div class="mx-auto max-w-screen-sm text-sm text-left text-neutral-light">
                        Skrbimo za varnost vaših podatkov. <a href="#" class="font-medium text-primary-light hover:underline">
                            Preberite našo politiko zasebnosti
                        </a>.
                    </div> -->
                </form>
            </div>
        </div>
    </section>
</template>
