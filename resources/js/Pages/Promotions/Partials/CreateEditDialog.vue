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

const emit = defineEmits(['submit', 'close', 'clearCurrentPromotion']);

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

// Handle form submission
// Handle form submission
const handleSubmit = () => {
    //form.start_date =new Date(form.start_date).toISOString().split('T')[0]; // Convert to ISO format
    //form.end_date = new Date(form.end_date).toISOString().split('T')[0]; // Convert to ISO format

    if (props.isEditMode) {
        // Update promotion
        promotionForm.put(route('promotions.update', props.promotion), {
            onSuccess: () => {
                emit('close')
                promotionForm.reset();
                emit('clearCurrentPromotion')
            },
        });
    } else {
        // Create promotion
        promotionForm.post(route('promotions.store'), {
            onSuccess: () => {
                emit('close')
                promotionForm.reset();
                emit('clearCurrentPromotion')
            },
        });
    }
};

const handleCancel = () => {
    emit('close');
    emit('clearCurrentPromotion')
    promotionForm.reset();
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
