<script setup>
import { ref } from 'vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import SubscribeSection from '@/Components/SubscribeSection.vue';
import UnsubscribeModal from './Akcije/Partials/UnsubscribeModal.vue';


const showUnsubscribeModal = ref(false);
</script>

<template>
    <SiteLayout
        title="Prijava na promocije in akcije"
        description="Prijavite se na promocije in akcije Čistilnice Suzi"
        keywords="akcije, promocije, čistilnica, suzi, prijava"
    >
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 md:space-y-12">

                <!-- Banner Section -->
                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
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
                <div class="overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <SubscribeSection class="rounded-lg" />
                </div>

                <!-- Links Section -->
                <div class="bg-primary-dark/40 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs p-6 lg:p-8 space-y-4">
                    <h2 class="font-heading text-2xl font-bold text-neutral-light">Upravljanje z akcijami</h2>
                    <ul class="text-neutral-light">
                        <li>
                            <button @click="showUnsubscribeModal = true" class="text-white hover:underline">
                                Odjava od akcij
                            </button>
                        </li>
                        <li v-if="$page.props.auth.user">
                            <a :href="route('promotions.index')" class="text-white hover:underline">
                                Uredi akcije
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <UnsubscribeModal :model-value="showUnsubscribeModal" @close="showUnsubscribeModal = false" />
    </SiteLayout>
</template>
