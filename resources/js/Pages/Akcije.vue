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

                <!-- Active promotions -->
                <div v-if="$page.props.active_promotions.length > 0" class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs p-6 lg:p-8">
                    <h2 class="font-heading text-2xl font-bold text-neutral-light">Aktivne akcije</h2>
                    <p class="text-neutral-light mt-4">
                        Oglejte si naše trenutne akcije in promocije. Prijavite se, da ne zamudite nobene priložnosti!
                    </p>
                    <div class="mt-4">
                        <ul class="text-neutral-light grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <li class="rounded-lg p-4 bg-primary-dark/65 flex flex-col justify-center items-center" v-for="promotion in $page.props.active_promotions" :key="promotion.id">
                                <span class="text-sm">od <b>{{ promotion.formatted_start_date }}</b> do <b>{{ promotion.formatted_end_date }}</b></span>
                                <hr class="w-full border-neutral-light/30 my-2" />
                                <h3 class="font-bold text-lg mb-2">{{ promotion.name }}</h3>
                                <div v-html="promotion.description"></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Upcoming promotions -->
                <div v-if="$page.props.upcoming_promotions.length > 0" class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs p-6 lg:p-8">
                    <h2 class="font-heading text-2xl font-bold text-neutral-light">Prihajajoče akcije</h2>
                    <p class="text-neutral-light mt-4">
                        Oglejte si naše prihajajoče akcije in promocije. Prijavite se, da ne zamudite nobene priložnosti!
                    </p>
                    <div class="mt-4">
                        <ul v-if="$page.props.upcoming_promotions.length > 0" class="text-neutral-light grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <li class="rounded-lg p-4 bg-primary-dark/65 flex flex-col justify-center items-center" v-for="promotion in $page.props.upcoming_promotions" :key="promotion.id">
                                <span class="text-sm">od <b>{{ promotion.formatted_start_date }}</b> do <b>{{ promotion.formatted_end_date }}</b></span>
                                <hr class="w-full border-neutral-light/30 my-2" />
                                <h3 class="font-bold text-lg mb-2">{{ promotion.name }}</h3>
                                <div v-html="promotion.description"></div>
                            </li>
                        </ul>

                    </div>
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
