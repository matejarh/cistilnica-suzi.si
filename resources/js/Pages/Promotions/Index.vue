<script setup>
import { ref, watch } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { formatDateToSlovenian, formatDateToISO } from '@/utils/dateUtils';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import PromotionCard from '@/Components/PromotionCard.vue';

// Get promotions from the page props
const { promotions } = usePage().props;

const showModal = ref(false);
const isEditMode = ref(false); // Determines if the modal is in edit mode
const currentPromotion = ref(null); // Holds the promotion being edited
const showDeleteConfirmationModal = ref(false); // State for showing the confirmation modal
const showSendConfirmationModal = ref(false); // State for showing the confirmation modal
const promotionToDelete = ref(null); // Holds the promotion to be deleted
const promotionToSend = ref(null); // Holds the promotion to be deleted
const confirmDeleteBusy = ref(false); // State for busy confirmation button
const confirmSendBusy = ref(false); // State for busy send confirmation button


const promotionForm = useForm({
    name: '',
    description: '',
    start_date: '',
    end_date: '',
});

const today = new Date().toISOString().split('T')[0]; // Current date in YYYY-MM-DD format

// Open the modal for creating a new promotion
const openCreateModal = () => {
    isEditMode.value = false;
    promotionForm.reset();
    showModal.value = true;
};

// Open the confirmation modal for deletion
const openDeleteConfirmation = (promotion) => {
    promotionToDelete.value = promotion;
    showDeleteConfirmationModal.value = true;
};

const openSendToSubscribersConfirmationModal = (promotion) => {
    // Logic to send the promotion to subscribers
    // console.log('Sending promotion to subscribers:', promotion);
    promotionToSend.value = promotion;
    showSendConfirmationModal.value = true;
};

// Open the modal for editing an existing promotion
const openEditModal = (promotion) => {
    isEditMode.value = true;
    currentPromotion.value = promotion;
    promotionForm.name = promotion.name;
    promotionForm.description = promotion.description;
    // promotionForm.start_date = formatDateToSlovenian(promotion.start_date); // Convert to Slovenian format
    // promotionForm.end_date = formatDateToSlovenian(promotion.end_date); // Convert to Slovenian format
    promotionForm.start_date = new Date(promotion.start_date); // Convert to Date object
    promotionForm.end_date = new Date(promotion.end_date); // Convert to Date object
    showModal.value = true;
};

// Handle deletion of the promotion
const confirmDelete = () => {
    if (promotionToDelete.value) {
        confirmDeleteBusy.value = true; // Set busy state
        // Perform the deletion using Inertia
        router.delete(route('promotions.destroy', promotionToDelete.value), {
            onSuccess: () => {
                showDeleteConfirmationModal.value = false;
                promotionToDelete.value = null;
                confirmDeleteBusy.value = false; // Reset busy state
            },
            onFinish: () => {
                confirmDeleteBusy.value = false; // Reset busy state
            },
            onError: (errors) => {
                console.error(errors);
                confirmDeleteBusy.value = false; // Reset busy state
            },
        });
    }
};

// Handle sending the promotion to subscribers
const confirmToSend = () => {
    if (promotionToSend.value) {
        confirmSendBusy.value = true; // Set busy state
        // Perform the sending using Inertia
        router.post(route('promotions.send', promotionToSend.value), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (page) => {
                if (page.props.flash.success) { // Check if success flash message exists
                    showSendConfirmationModal.value = false;
                    promotionToSend.value = null;
                }
                confirmSendBusy.value = false; // Reset busy state
            },
            onFinish: () => {
                confirmSendBusy.value = false; // Reset busy state
            },
            onError: (errors) => {
                console.error(errors);
                confirmSendBusy.value = false; // Reset busy state
            },
        });
    }
};

// Handle form submission
const handleSubmit = () => {
    promotionForm.start_date = promotionForm.start_date.toISOString().split('T')[0]; // Convert to ISO format
    promotionForm.end_date = promotionForm.end_date.toISOString().split('T')[0]; // Convert to ISO format

    if (isEditMode.value) {
        // Update promotion
        promotionForm.put(route('promotions.update', currentPromotion.value), {
            onSuccess: () => {
                showModal.value = false;
                promotionForm.reset();
                currentPromotion.value = null;
            },
        });
    } else {
        // Create promotion
        promotionForm.post(route('promotions.store'), {
            onSuccess: () => {
                showModal.value = false;
                promotionForm.reset();
                currentPromotion.value = null;
            },
        });
    }
};

// Watchers for validation
watch(
    () => promotionForm.start_date,
    (newStartDate) => {
        const now = new Date().toISOString().split('T')[0]; // Current date in YYYY-MM-DD format
        if (newStartDate < now) {
            promotionForm.errors.start_date = 'Začetni datum ne sme biti pred današnjim datumom.';
            promotionForm.start_date = now;
        } else {
            promotionForm.errors.start_date = null;
        }

        // Automatically set end_date to 7 days from start_date if it's empty or invalid
        if (!promotionForm.end_date || promotionForm.end_date < newStartDate) {
            const startDate = new Date(newStartDate);
            const defaultEndDate = new Date(startDate.setDate(startDate.getDate() + 7))
                .toISOString()
                .split('T')[0];
            promotionForm.end_date = defaultEndDate;
        }
    }
);

watch(
    () => promotionForm.end_date,
    (newEndDate) => {
        if (newEndDate < promotionForm.start_date) {
            promotionForm.errors.end_date = 'Končni datum ne sme biti pred začetnim datumom.';
            promotionForm.end_date = promotionForm.start_date;
        } else {
            promotionForm.errors.end_date = null;
        }
    }
);
</script>

<template>
    <SiteLayout title="Upravljanje akcij" description="Pregled, urejanje in brisanje akcij Čistilnice Suzi"
        keywords="upravljanje, akcije, čistilnica, suzi, urejanje, brisanje">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Page Header -->
                <div class="bg-primary/60 overflow-hidden shadow-xl sm:rounded-lgbackdrop-blur-xs p-6">
                    <h1 class="text-3xl font-bold text-neutral-light">Upravljanje akcij</h1>
                    <p class="text-neutral-light mt-2">
                        Tukaj lahko pregledate, urejate ali izbrišete obstoječe akcije.
                    </p>
                    <div class="mt-4">
                        <button @click="openCreateModal"
                            class="px-4 py-2 bg-primary-light text-white rounded-lg hover:bg-primary">
                            Dodaj novo akcijo
                        </button>
                    </div>
                </div>

                <!-- Promotions List -->
                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-primary-dark">Seznam akcij</h2>
                    <div v-if="$page.props.promotions.total > 0" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <PromotionCard
                                v-for="promotion in $page.props.promotions.data"
                                :key="promotion.id"
                                :promotion="promotion"
                                @edit="openEditModal(promotion)"
                                @delete="openDeleteConfirmation(promotion)"
                                @send="openSendToSubscribersConfirmationModal(promotion)"
                            />
                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        Trenutno ni dodane nobene akcije.
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog Modal -->
        <DialogModal :show="showModal" @close="showModal = false">
            <template #title>
                <h2 class="text-lg font-semibold text-neutral-light">
                    {{ isEditMode ? 'Uredi akcijo' : 'Dodaj novo akcijo' }}
                </h2>
            </template>
            <template #content>
                <form @submit.prevent="handleSubmit" class="space-y-4">
                    <div>
                        <InputLabel for="name" value="Naslov" />
                        <input id="name" v-model="promotionForm.name" type="text" required
                            class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                            placeholder="Vnesite naslov akcije" />
                        <InputError :message="promotionForm.errors.name" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="description" value="Opis" />
                        <textarea id="description" v-model="promotionForm.description" required
                            class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                            placeholder="Vnesite opis akcije"></textarea>
                        <InputError :message="promotionForm.errors.description" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="start_date" value="Začetni datum" />
                            <Datepicker class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                                        v-model="promotionForm.start_date"
                                        :locale="'sl'"
                                        :format="'dd.MM.yyyy'"
                                        cancelText="prekliči"
                                        selectText="izberi"
                                        :min-date="today"
                                        :max-date="promotionForm.end_date" />
                            <!-- <input id="start_date" v-model="promotionForm.start_date" type="text" placeholder="dd.MM.yyyy" lang="sl-SI" required
                                class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light" /> -->
                            <InputError :message="promotionForm.errors.start_date" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="end_date" value="Končni datum" />
                            <Datepicker class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                                        v-model="promotionForm.end_date"
                                        :locale="'sl'"
                                        :format="'dd.MM.yyyy'"
                                        cancelText="prekliči"
                                        selectText="izberi"
                                        :min-date="promotionForm.start_date || today" />
                            <!-- <input id="end_date" v-model="promotionForm.end_date" type="text" placeholder="dd.MM.yyyy" lang="sl-SI" required
                                class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light" /> -->
                            <InputError :message="promotionForm.errors.end_date" class="mt-2" />
                        </div>
                    </div>
                </form>
            </template>
            <template #footer>
                <div class="flex items-center space-x-4">
                    <button @click="showModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                        Prekliči
                    </button>
                    <button @click="handleSubmit" :disabled="promotionForm.processing"
                        class="flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-light disabled:opacity-50">
                        <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="promotionForm.processing" />
                        {{ promotionForm.processing ? 'Shranjujem...' : 'Shrani' }}
                    </button>
                </div>
            </template>
        </DialogModal>

        <!-- Confirmation Modal -->
        <ConfirmationModal :show="showDeleteConfirmationModal" @close="showDeleteConfirmationModal = false">
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
        </ConfirmationModal>

        <!-- Confirmation Modal -->
        <ConfirmationModal :show="showSendConfirmationModal" @close="showSendConfirmationModal = false">
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
        </ConfirmationModal>
    </SiteLayout>
</template>
