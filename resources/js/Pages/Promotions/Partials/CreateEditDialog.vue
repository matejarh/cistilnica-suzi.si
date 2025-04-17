<!-- filepath: resources/js/Components/CreateEditDialog.vue -->
<script setup>
import { defineAsyncComponent, ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import '@vuepic/vue-datepicker/dist/main.css';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import DialogModal from '@/Components/DialogModal.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';

const TipTapInput = defineAsyncComponent(() =>
    import('@/Components/TipTapInput.vue')
);
const Datepicker = defineAsyncComponent(() =>
    import('@vuepic/vue-datepicker')
);

const props = defineProps({
    show: Boolean,
    isEditMode: Boolean,
    promotion: Object,
    onClose: Function,
});

// Emit events for parent component
const emit = defineEmits(['submit', 'close', 'clearCurrentPromotion']);

// Initialize form
// The form is initialized with empty values
// and will be populated when the dialog is opened
const promotionForm = useForm({
    name: '',
    description: '',
    start_date: '',
    end_date: '',
});

const today = new Date().toISOString().split('T')[0];

// Initialize form when the dialog is opened
watch(
    () => props.show,
    (newValue) => {
        if (newValue) {
            promotionForm.clearErrors();
            if (props.isEditMode && props.promotion) {
                promotionForm.name = props.promotion.name;
                promotionForm.description = props.promotion.description;
                promotionForm.start_date = props.promotion.start_date;
                promotionForm.end_date = props.promotion.end_date;
            } else {
                promotionForm.reset();
            }
        }
    }
);

// Watchers for handling dates and validation
// Automatically set end_date to 7 days from start_date if it's empty or invalid
// Automatically set start_date to today if it's empty or invalid
watch(
    () => promotionForm.start_date,
    (newStartDate) => {
        if (!newStartDate) {
            promotionForm.errors.start_date = 'Začetni datum je obvezen.';
            return;
        }
        const now = new Date().toISOString().split('T')[0]; // Current date in YYYY-MM-DD format
        if (newStartDate < now && !props.isEditMode) {
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

// Handle form submission
// This function is called when the user clicks the "Shrani" button
// It checks if the form is in edit mode or create mode
// and sends the appropriate request to the server
// If the form is in edit mode, it sends a PUT request to update the promotion
// If the form is in create mode, it sends a POST request to create a new promotion
const handleSubmit = () => {

    if (props.isEditMode) {
        // Update promotion
        promotionForm.put(route('promotions.update', props.promotion), {
            onSuccess: () => {
                emit('close')
                emit('clearCurrentPromotion')
                resetForm();
            },
        });
    } else {
        // Create promotion
        promotionForm.post(route('promotions.store'), {
            onSuccess: () => {
                emit('close')
                emit('clearCurrentPromotion')
                resetForm();
            },
        });
    }
};

const resetForm = () => {
    setTimeout(() => {
        promotionForm.clearErrors();
        promotionForm.reset();
    }, 500);
};

// Handle cancel button click
// This function is called when the user clicks the "Prekliči" button
// It resets the form and closes the dialog
const handleCancel = () => {
    emit('close');
    emit('clearCurrentPromotion');
    resetForm();
};
</script>

<template>
    <DialogModal :show="show" @close="onClose" max-width="4xl">
        <template #title>
            <h2 class="text-lg font-semibold text-neutral-light">
                {{ isEditMode ? 'Uredi akcijo' : 'Dodaj novo akcijo' }}
            </h2>
        </template>
        <template #content>
            <form class="space-y-4">
                <div>
                    <InputLabel for="name" value="Naslov" class="mb-2" />
                    <input
                        id="name"
                        v-model="promotionForm.name"
                        type="text"
                        required
                        class="block p-3 w-full text-sm text-neutral-dark rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light"
                        placeholder="Vnesite naslov akcije"
                    />
                    <InputError :message="promotionForm.errors.name" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="description" value="Opis" class="mb-2" />
                    <TipTapInput v-model="promotionForm.description" :has-error="!!promotionForm.errors.description" />
                    <InputError :message="promotionForm.errors.description" class="mt-2" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <InputLabel for="start_date" value="Začetni datum" class="mb-2" />
                        <Datepicker
                            v-model="promotionForm.start_date"
                            :locale="'sl'"
                            :format="'dd.MM.yyyy'"
                            cancelText="prekliči"
                            selectText="izberi"
                            placeholder="Izberi datum"
                            :min-date="today"
                            :max-date="promotionForm.end_date"
                        />
                        <InputError :message="promotionForm.errors.start_date" class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="end_date" value="Končni datum" class="mb-2" />
                        <Datepicker
                            v-model="promotionForm.end_date"
                            :locale="'sl'"
                            :format="'dd.MM.yyyy'"
                            cancelText="prekliči"
                            selectText="izberi"
                            placeholder="Izberi datum"
                            :min-date="promotionForm.start_date || today"
                        />
                        <InputError :message="promotionForm.errors.end_date" class="mt-2" />
                    </div>
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex items-center space-x-4">
                <button @click="handleCancel" class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                    Prekliči
                </button>
                <button
                    @click="handleSubmit"
                    :disabled="promotionForm.processing"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-light disabled:opacity-50"
                >
                    <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="promotionForm.processing" />
                    {{ promotionForm.processing ? 'Shranjujem...' : 'Shrani' }}
                </button>
            </div>
        </template>
    </DialogModal>
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
