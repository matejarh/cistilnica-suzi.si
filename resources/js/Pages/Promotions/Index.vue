<script setup>
import { defineAsyncComponent, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { trim } from 'lodash';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import PromotionCard from '@/Components/PromotionCard.vue';
import AdminNav from '@/Components/AdminNav.vue';
import Filters from './Partials/Filters.vue';
const CreateEditDialog = defineAsyncComponent(() => import('./Partials/CreateEditDialog.vue'));
const DeleteConfirmationDialog = defineAsyncComponent(() => import('./Partials/DeleteConfirmationDialog.vue'));
const SendToSubscribersConfirmationDialog = defineAsyncComponent(() => import('./Partials/SendToSubscribersConfirmationDialog.vue'));

const props = defineProps({
    promotions: Object,
    filters: Object,
})

const showModal = ref(false);
const isEditMode = ref(false); // Determines if the modal is in edit mode
const currentPromotion = ref(null); // Holds the promotion being edited
const showDeleteConfirmationModal = ref(false); // State for showing the confirmation modal
const showSendConfirmationModal = ref(false); // State for showing the confirmation modal
const promotionToDelete = ref(null); // Holds the promotion to be deleted
const promotionToSend = ref(null); // Holds the promotion to be deleted

const form = ref({
    search: props.filters.search,
    status: props.filters.status ? props.filters.status : "",
    deleted: props.filters.deleted ? props.filters.deleted : "",
    per_page: props.filters.per_page ? props.filters.per_page : 12,
})

const debouncedHandler = debounce(() => {
    form.value.search = trim(form.value.search)
    router.get(route('promotions.index'), pickBy(form.value), {
        preserveState: true,
        preserveScroll: true,
    });
}, 500);

watch(form, debouncedHandler, { deep: true });

const reset = () => {
    form.value = mapValues(form.value, () => null);
};



// Open the modal for creating a new promotion
const openCreateModal = () => {
    isEditMode.value = false;
    showModal.value = true;
};

// Open the confirmation modal for deletion
const openDeleteConfirmation = (promotion) => {
    promotionToDelete.value = promotion;
    showDeleteConfirmationModal.value = true;
};

const openSendToSubscribersConfirmationModal = (promotion) => {
    promotionToSend.value = promotion;
    showSendConfirmationModal.value = true;
};

// Open the modal for editing an existing promotion
const openEditModal = (promotion) => {
    isEditMode.value = true;
    currentPromotion.value = promotion;
    showModal.value = true;
};

</script>

<template>
    <SiteLayout title="Upravljanje akcij" description="Pregled, urejanje in brisanje akcij Čistilnice Suzi"
        keywords="upravljanje, akcije, čistilnica, suzi, urejanje, brisanje">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Page Header -->
                <AdminNav />
                <div class="bg-primary/60 overflow-hidden shadow-xl sm:rounded-lg backdrop-blur-xs p-6">
                    <h1 class="text-3xl font-bold text-neutral-light">Upravljanje z akcijam</h1>
                    <p class="text-neutral-light mt-2">
                        Tukaj lahko pregledate, urejate ali izbrišete obstoječe akcije.
                        <br />
                        Dodajte nove akcije, ki jih želite poslati svojim naročnikom.
                        <br />
                        Vsaka akcija ima svoj naslov, opis in datume veljavnosti.
                        <br />
                        Akcije lahko pošljete vsem naročnikom, da jih obvestite o posebnih ponudbah ali popustih.
                        <br />
                        Uporabite to funkcionalnost za učinkovito komunikacijo s svojimi strankami.


                    </p>
                    <!-- <div class="mt-2">
                        <div class="text-neutral-light flex items-center space-x-2">
                            <span>
                                Akcije pošljete vsem naročnikom s pritiskom na ikono
                            </span>
                            <PaperAirplaneIcon class="w-5 h-5 text-blue-500 " />
                        </div>
                        <div class="text-neutral-light flex items-center space-x-2">
                            <span>
                                Akcije lahko izbrišete s pritiskom na ikono
                            </span>
                            <TrashIcon class="w-5 h-5 text-red-500 " />
                        </div>
                        <div class="text-neutral-light flex items-center space-x-2">
                            <span>
                                Akcije lahko uredite s pritiskom na ikono
                            </span>
                            <PencileSquareIcon class="w-5 h-5 text-blue-500 " />
                        </div>
                    </div> -->
                    <div class="mt-4">
                        <button @click="openCreateModal"
                            class="px-4 py-2 bg-primary-dark text-white rounded-lg hover:bg-primary-dark/70 cursor-pointer">
                            Dodaj novo akcijo
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <Filters v-model:filters="form" @reset="reset" />
                </div>

                <!-- Promotions List -->
                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-primary-dark">Seznam akcij</h2>
                    <div v-if="$page.props.promotions.total > 0" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <PromotionCard v-for="promotion in $page.props.promotions.data" :key="promotion.id"
                                :promotion="promotion" @edit="openEditModal(promotion)"
                                @delete="openDeleteConfirmation(promotion)"
                                @send="openSendToSubscribersConfirmationModal(promotion)" />
                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        Trenutno ni dodane nobene akcije.
                    </div>
                    <Paginator :links="$page.props.promotions.links" :for-each-side="3" class="mt-4" />
                </div>
            </div>
        </div>

        <!-- Create/Edit Dialog -->
        <CreateEditDialog :show="showModal" :is-edit-mode="isEditMode" :promotion="currentPromotion"
            @close="showModal = false" @clear-current-promotion="currentPromotion = null" />

        <!-- Delete Confirmation Dialog -->
        <DeleteConfirmationDialog :show="showDeleteConfirmationModal" :promotion="promotionToDelete"
            @close="showDeleteConfirmationModal = false" @clear-promotion-to-delete="promotionToDelete = null" />

        <!-- Send To Subscribers Confirmation Dialog -->
        <SendToSubscribersConfirmationDialog :show="showSendConfirmationModal" :promotion="promotionToSend"
            @close="showSendConfirmationModal = false" @clear-promotion-to-send="promotionToSend = null" />
    </SiteLayout>
</template>
