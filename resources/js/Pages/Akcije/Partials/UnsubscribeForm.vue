<script setup>
import Alert from '@/Components/Alert.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import EnvelopeSolidIcon from '@/Icons/EnvelopeSolidIcon.vue';
import ExclamationIcon from '@/Icons/ExclamationIcon.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const page = usePage();


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
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

onMounted(() => {
    if (page.props.email) {
        unsubscribeForm.email = page.props.email;
    }
});
</script>

<template>
    <section class="bg-primary-dark/30 text-neutral-light backdrop-blur-xs">
        <div class="py-8 px-4 mx-auto max-w-(--breakpoint-xl) lg:py-16 lg:px-6">
            <div class="mx-auto max-w-(--breakpoint-md) text-center">
                <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-primary-light sm:text-4xl">
                    Odjava od promocij
                </h2>
                <p class="mx-auto mb-8 max-w-2xl font-light text-neutral-light sm:text-xl">Za odjavo od akcij vnesite
                    elektronski naslov, s katerim ste se prijavili na akcije.</p>


                <form @submit.prevent="submitUnsubscribe" class="space-y-4">
                    <div class="items-center mx-auto mb-3 space-y-4 max-w-(--breakpoint-sm) sm:flex sm:space-y-0">
                        <div class="relative w-full">
                            <label for="email" class="hidden mb-2 text-sm font-medium text-neutral-light">
                                E-poštni naslov
                            </label>
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <EnvelopeSolidIcon class="w-5 h-5 "
                                    :class="unsubscribeForm.errors.email ? 'text-red-500' : 'text-primary'" />
                            </div>
                            <input ref="emailInput" v-model="unsubscribeForm.email" autocomplete="email"
                                class="block p-3 pl-10 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light sm:rounded-none sm:rounded-l-lg"
                                :class="inputClasses" placeholder="Vnesite vaš e-poštni naslov" type="email" id="email"
                                required>
                        </div>

                        <div>
                            <button type="submit" :disabled="unsubscribeForm.processing || !unsubscribeForm.isDirty"
                                class="flex items-center whitespace-nowrap py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary hover:bg-primary-light   sm:rounded-none sm:rounded-r-lg disabled:opacity-50 transition ease-in-out duration-150">
                                <Cog8ToothIcon class="w-4 h-4 mr-2 animate-spin" v-show="unsubscribeForm.processing" />
                                {{ unsubscribeForm.processing ? 'Odjavljam...' : 'Odjavi me' }}
                            </button>
                        </div>
                    </div>
                    <span v-if="unsubscribeForm.errors.email"
                        class="text-sm text-red-500 bg-white rounded-lg px-2 py-1 flex items-center">
                        <ExclamationIcon class="w-5 h-5 text-red-500 mr-2" />

                        {{ unsubscribeForm.errors.email }}
                    </span>
                    <!-- <div class="mx-auto max-w-(--breakpoint-sm) text-sm text-left text-neutral-light">
                        Skrbimo za varnost vaših podatkov. <a href="#" class="font-medium text-primary-light hover:underline">
                            Preberite našo politiko zasebnosti
                        </a>.
                    </div> -->
                </form>


                <Alert type="info"
                    message="Na vaš naslov po poslano sporočilo s povezavo za potrditev.<br>Povezavo morate odpreti v tem brskalniku, drugače bo seja neveljavna.<br>Če sporočila ne prejmete, preverite mapo z vsiljeno pošto." />
            </div>
        </div>
    </section>
</template>
