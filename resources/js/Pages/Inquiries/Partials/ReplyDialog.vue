<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import Cog8ToothIcon from '@/Icons/Cog8ToothIcon.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    show: Boolean,
    inquiry: Object,
    onClose: Function,
});

const form = useForm({
    reply: '',
});

// Emit events for parent component
const emit = defineEmits(['submit', 'close', 'clearCurrentINquiry']);

const handleCancel = () => {
    form.clearErrors();
    emit('close');
};

const handleSubmit = () => {
    form.post(route('inquiries.reply', props.inquiry), {
        onSuccess: () => {
            emit('close');

            form.reset();
        },
        onFinish: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>

<template>
    <DialogModal :show="show" @close="onClose" max-width="4xl">
        <template #title>
            <h2 class="text-lg font-semibold text-neutral-light">
                Odgovori na poizvedbo
            </h2>
        </template>
        <template #content>
            <div class="mt-4 text-sm text-neutral-light">
                <p class="mb-2">Ali želite odgovoriti na poizvedbo?</p>
                <p class="mb-2" v-if="inquiry">{{ inquiry.name }}</p>
                <p class="mb-2 text-neutral-500" v-if="inquiry">
                    {{ new Date(inquiry.created_at).toLocaleDateString('sl-SI') }}
                </p>
                <div class="mb-2 text-neutral-dark bg-neutral-light rounded-lg p-2" v-if="inquiry" v-html="inquiry.message.replace(/<br\s*\/?>/gi, '<br>')">
                </div>

                <textarea v-model="form.reply" rows="5" class="w-full p-2 border-2 border-primary  rounded-lg" :class="[
                    form.errors.reply ? 'bg-red-100 border-red-500 text-red-900 placeholder-red-500 focus:ring-red-500 focus:border-red-500' : 'bg-neutral-light border-primary text-neutral-dark placeholder-neutral-dark',
                    'block w-full pl-4 pr-10 py-2 text-sm rounded-lg focus:ring-primary focus:border-primary',
                ]"
                    placeholder="Vnesite odgovor..."></textarea>
                <InputError :message="form.errors.reply" class="mt-2" />
            </div>
        </template>

        <template #footer>
            <div class="flex items-center space-x-4">
                <button @click="handleCancel"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-neutral rounded-lg hover:bg-gray-300">
                    Prekliči
                </button>
                <button @click="handleSubmit" :disabled="form.processing"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-light disabled:opacity-50">
                    <Cog8ToothIcon class="w-5 h-5 mr-2 animate-spin" v-show="form.processing" />
                    {{ form.processing ? 'Pošiljam...' : 'Pošlji' }}
                </button>
            </div>
        </template>
    </DialogModal>
</template>
