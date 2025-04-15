<script setup>
import { defineAsyncComponent, ref } from 'vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import PromotionCard from '@/Components/PromotionCard.vue';
import PaperAirplaneIcon from '@/Icons/PaperAirplaneIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';
import PencileSquareIcon from '@/Icons/PencileSquareIcon.vue';
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

<style>
:root {
    /*General*/
    --dp-font-family: "Latto", "Segoe UI", "Roboto", "Helvetica", "Arial", "Noto Sans", sans-serif;
    /*Font family*/
    --dp-border-radius: 0.5rem;
    /*Configurable border-radius*/
    --dp-cell-border-radius: 0.2rem;
    /*Specific border radius for the calendar cell*/
    --dp-common-transition: all 0.1s ease-in;
    /*Generic transition applied on buttons and calendar cells*/

    /*Sizing*/
    --dp-button-height: 35px;
    /*Size for buttons in overlays*/
    --dp-month-year-row-height: 35px;
    /*Height of the month-year select row*/
    --dp-month-year-row-button-size: 35px;
    /*Specific height for the next/previous buttons*/
    --dp-button-icon-height: 20px;
    /*Icon sizing in buttons*/
    --dp-cell-size: 35px;
    /*Width and height of calendar cell*/
    --dp-cell-padding: 5px;
    /*Padding in the cell*/
    --dp-common-padding: 10px;
    /*Common padding used*/
    --dp-input-icon-padding: 35px;
    /*Padding on the left side of the input if icon is present*/
    --dp-input-padding: 6px 30px 6px 12px;
    /*Padding in the input*/
    --dp-input-padding: calc(var(--spacing) * 3);
    /*Padding in the input*/
    --dp-menu-min-width: 260px;
    /*Adjust the min width of the menu*/
    --dp-action-buttons-padding: 2px 5px;
    /*Adjust padding for the action buttons in action row*/
    --dp-row-margin: 5px 0;
    /*Adjust the spacing between rows in the calendar*/
    --dp-calendar-header-cell-padding: 0.5rem;
    /*Adjust padding in calendar header cells*/
    --dp-two-calendars-spacing: 10px;
    /*Space between multiple calendars*/
    --dp-overlay-col-padding: 3px;
    /*Padding in the overlay column*/
    --dp-time-inc-dec-button-size: 32px;
    /*Sizing for arrow buttons in the time picker*/
    --dp-menu-padding: 6px 8px;
    /*Menu padding*/

    /*Font sizes*/
    --dp-font-size: 0.875rem;
    /*Default font-size*/
    --dp-preview-font-size: 0.8rem;
    /*Font size of the date preview in the action row*/
    --dp-time-font-size: 0.8rem;
    /*Font size in the time picker*/

    /*Transitions*/
    --dp-animation-duration: 0.1s;
    /*Transition duration*/
    --dp-menu-appear-transition-timing: cubic-bezier(.4, 0, 1, 1);
    /*Timing on menu appear animation*/
    --dp-transition-timing: ease-out;
    /*Timing on slide animations*/
}
</style>
