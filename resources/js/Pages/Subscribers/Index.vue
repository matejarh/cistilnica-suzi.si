<script setup>
import { defineAsyncComponent, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { trim } from 'lodash';
import AdminNav from '@/Components/AdminNav.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import Filters from './Partials/Filters.vue';
import SubscriberCard from '@/Components/SubscriberCard.vue';
import Paginator from '@/Components/Paginator.vue';
const SendToSubscribersConfirmationDialog = defineAsyncComponent(() => import('./Partials/SendToSubscribersConfirmationDialog.vue'));
const DeleteConfirmationDialog = defineAsyncComponent(() => import('./Partials/DeleteConfirmationDialog.vue'));
const SubscriberModal = defineAsyncComponent(() => import('./Partials/SubscriberModal.vue'));

const props = defineProps({
    subscribers: Object,
    filters: Object,
});

const showModal = ref(false);
const currentSubscriber = ref(null);
const showDeleteConfirmationModal = ref(false);
const showSendConfirmationModal = ref(false);

const form = ref({
    search: props.filters?.search ?? '',
    per_page: props.filters?.per_page ?? 12,
});

const debouncedHandler = debounce(() => {
    form.value.search = trim(form.value.search)
    router.get(route('subscribers.index'), pickBy(form.value), {
        preserveState: true,
        preserveScroll: true,
    });
}, 500);

watch(form, debouncedHandler, { deep: true });

const reset = () => {
    form.value = mapValues(form.value, () => null);
};

const openCreateModal = () => {
    showModal.value = true;
    // Logic to open the create modal
};
const openEditModal = (subscriber) => {
    // Logic to open the edit modal with the selected subscriber
};
const openDeleteConfirmation = (subscriber) => {
    // Logic to open the delete confirmation modal with the selected subscriber
    currentSubscriber.value = subscriber;
    showDeleteConfirmationModal.value = true;
};
const openSendToSubscribersConfirmationModal = (subscriber) => {
    // Logic to open the send confirmation modal with the selected subscriber
    currentSubscriber.value = subscriber;
    showSendConfirmationModal.value = true;
};
</script>

<template>
    <SiteLayout title="Upravljanje naročnikov" description="Pregled, urejanje in brisanje naročnikov Čistilnice Suzi">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Page Header -->
                <AdminNav />

                <div class="bg-primary/60 overflow-hidden shadow-xl sm:rounded-lg backdrop-blur-xs p-6">
                    <h1 class="text-3xl font-bold text-neutral-light">Upravljanje z naročniki</h1>

                    <p class="text-neutral-light mt-2">
                        Na tej strani lahko upravljate z naročniki Čistilnice Suzi. Dodajte, uredite ali izbrišite
                        naročnike ter
                        jih obveščajte o akcijah in novostih.
                        <br />
                        Uporabite iskalno vrstico za hitro iskanje naročnikov po imenu ali e-pošti.
                        <br />
                        Dodajte nove naročnike, da razširite svojo bazo strank in povečate prodajo.
                        <br />
                        Uporabite to funkcionalnost za učinkovito komunikacijo s svojimi strankami.
                        <br />
                    </p>

                    <div class="mt-4">
                        <button @click="openCreateModal"
                            class="px-4 py-2 bg-primary-dark text-white rounded-lg hover:bg-primary-dark/70 cursor-pointer">
                            Dodaj naročnika
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <Filters v-model:filters="form" @reset="reset" />
                </div>

                <!-- Subscribers List -->
                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-primary-dark">Seznam naročnikov</h2>
                    <div v-if="$page.props.subscribers.total > 0" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div v-for="subscriber in $page.props.subscribers.data" :key="subscriber.id">
                                <SubscriberCard :subscriber="subscriber" @delete="openDeleteConfirmation"
                                    @send="openSendToSubscribersConfirmationModal" />
                            </div>

                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        Trenutno ni nobenega naročnika.
                    </div>
                    <Paginator :links="$page.props.subscribers.links" :for-each-side="3" class="mt-4" />
                </div>
            </div>
        </div>

        <!-- Create/Edit Subscriber Modal -->
        <SubscriberModal :show="showModal" :subscriber="currentSubscriber" @close="showModal = false" />

        <!-- Delete Confirmation Dialog -->
        <DeleteConfirmationDialog :show="showDeleteConfirmationModal" :subscriber="currentSubscriber"
            @close="showDeleteConfirmationModal = false" @clear-promotion-to-delete="promotionToDelete = null" />

        <!-- Send To Subscribers Confirmation Dialog -->
        <SendToSubscribersConfirmationDialog :show="showSendConfirmationModal" :subscriber="currentSubscriber"
            @close="showSendConfirmationModal = false" @clear-current-subscriber="currentSubscriber = null" />
    </SiteLayout>

</template>
