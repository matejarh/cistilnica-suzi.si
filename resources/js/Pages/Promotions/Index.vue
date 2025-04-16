<script setup>
import { defineAsyncComponent, ref } from 'vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import PromotionCard from '@/Components/PromotionCard.vue';
import PaperAirplaneIcon from '@/Icons/PaperAirplaneIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';
import PencileSquareIcon from '@/Icons/PencileSquareIcon.vue';
import AdminNav from '@/Components/AdminNav.vue';
const CreateEditDialog = defineAsyncComponent(() => import('./Partials/CreateEditDialog.vue'));
const DeleteConfirmationDialog = defineAsyncComponent(() => import('./Partials/DeleteConfirmationDialog.vue'));
const SendToSubscribersConfirmationDialog = defineAsyncComponent(() => import('./Partials/SendToSubscribersConfirmationDialog.vue'));


const showModal = ref(false);
const isEditMode = ref(false); // Determines if the modal is in edit mode
const currentPromotion = ref(null); // Holds the promotion being edited
const showDeleteConfirmationModal = ref(false); // State for showing the confirmation modal
const showSendConfirmationModal = ref(false); // State for showing the confirmation modal
const promotionToDelete = ref(null); // Holds the promotion to be deleted
const promotionToSend = ref(null); // Holds the promotion to be deleted


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
                <div class="bg-primary/60 overflow-hidden shadow-xl sm:rounded-lgbackdrop-blur-xs p-6">
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
                    <div class="mt-2">
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
                    </div>
                    <div class="mt-4">
                        <button @click="openCreateModal"
                            class="px-4 py-2 bg-primary-dark text-white rounded-lg hover:bg-primary-dark/70 cursor-pointer">
                            Dodaj novo akcijo
                        </button>
                    </div>
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
                </div>
            </div>
        </div>

        <!-- Create/Edit Dialog -->
        <CreateEditDialog :show="showModal" :is-edit-mode="isEditMode" :promotion="currentPromotion"
            @close="showModal = false" @clear-current-promotion="showModal = false" />

        <!-- Delete Confirmation Dialog -->
        <DeleteConfirmationDialog :show="showDeleteConfirmationModal" :promotion="promotionToDelete"
            @close="showDeleteConfirmationModal = false" @clear-promotion-to-delete="promotionToDelete = null" />

        <!-- Send To Subscribers Confirmation Dialog -->
        <SendToSubscribersConfirmationDialog :show="showSendConfirmationModal" :promotion="promotionToSend"
            @close="showSendConfirmationModal = false" @clear-promotion-to-send="promotionToSend = null" />

        <!-- Delete Confirmation Dialog -->
<!--         <ConfirmationModal :show="showDeleteConfirmationModal" @close="showDeleteConfirmationModal = false">
            <template #title>
                Potrditev izbrisa
            </template>
            <template #content>
                Ali ste prepričani, da želite izbrisati akcijo "<strong>{{ promotionToDelete?.name }}</strong>"?
                Ta dejanje je nepovratno.
            </template>
            <template #footer>
                <button @click="showDeleteConfirmationModal = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                    Prekliči
                </button>
                <button @click="confirmDelete" :disabled="confirmDeleteBusy"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 disabled:opacity-50">
                    <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="confirmDeleteBusy" />
                    {{ confirmDeleteBusy ? 'Brišem...' : 'Izbriši' }}

                </button>
            </template>
        </ConfirmationModal> -->

        <!-- Send To Subscribers Confirmation Dialog -->
<!--         <ConfirmationModal :show="showSendConfirmationModal" @close="showSendConfirmationModal = false">
            <template #title>
                Potrditev pošiljanja akcije
            </template>
            <template #content>
                Ali ste prepričani, da želite poslati akcijo "<strong>{{ promotionToSend?.name }}</strong>" vsem
                naročnikom?
                Prepričajte se, da so podatki pravilni, saj bo akcija poslana takoj.
            </template>
            <template #footer>
                <button @click="showSendConfirmationModal = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                    Prekliči
                </button>
                <button @click="confirmToSend" :disabled="confirmSendBusy"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 disabled:opacity-50">
                    <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="confirmSendBusy" />
                    {{ confirmSendBusy ? 'Pošiljam...' : 'Pošlji' }}

                </button>
            </template>
        </ConfirmationModal> -->
    </SiteLayout>
</template>
