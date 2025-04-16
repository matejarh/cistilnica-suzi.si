<script setup>
import PaperAirplaneIcon from '@/Icons/PaperAirplaneIcon.vue';
import PencileSquareIcon from '@/Icons/PencileSquareIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';
import Tooltip from './Tooltip.vue';
import Badge from './Badge.vue';

defineProps({
    promotion: {
        type: Object,
        required: true,
    },
});

defineEmits(['send', 'edit', 'delete']);

// Format dates for display
const formatDate = (date) => new Date(date).toLocaleDateString('sl-SI');
</script>

<template>
    <div class="border-b pb-4 bg-neutral-light/60 rounded-lg shadow-lg p-4 relative">
        <div class="absolute inset-x-0 -top-2 flex justify-center">
            <Badge :color="promotion.status_color">
                {{ promotion.status }}
            </Badge>
        </div>
        <div class="mb-2 flex justify-between border-b border-neutral-dark pb-2">
            <div class="flex space-x-4">
                <Tooltip text="Pošlji" location="top">
                    <button @click="$emit('send', promotion)"
                        class="text-primary hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        <PaperAirplaneIcon class="w-5 h-5 " />

                    </button>
                </Tooltip>

                <Tooltip text="Uredi" location="top">
                    <button @click="$emit('edit', promotion)"
                        class="text-primary hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        <PencileSquareIcon class="w-5 h-5 " />

                    </button>
                </Tooltip>
            </div>
            <Tooltip text="Izbriši" location="top">
                <button @click="$emit('delete', promotion)"
                    class="text-red-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                    <TrashIcon class="w-5 h-5 " />
                </button>
            </Tooltip>
        </div>

        <h3 class="text-lg font-semibold text-neutral-dark">{{ promotion.name }}</h3>

        <div id="description" class="text-neutral-dark bg-neutral-100 border-neutral rounded-lg p-2"
            v-html="promotion.description"></div>

        <p class="text-neutral-500 text-sm flex justify-between">
            <span>
                Začetni datum:<br />{{ formatDate(promotion.start_date) }}
            </span>
            <span>
                Končni datum:<br />{{ formatDate(promotion.end_date) }}
            </span>
        </p>
    </div>
</template>

<style scoped>
::v-deep(#description h1) {
    font-size: 1.25rem;
    font-weight: bold;
}

::v-deep(#description h2) {
    font-size: 1.125rem;
    font-weight: bold;
}

::v-deep(#description h3) {
    font-size: 1rem;
    font-weight: bold;
}

::v-deep(#description h4) {
    font-size: 0.875rem;
    font-weight: bold;
}

::v-deep(#description h5) {
    font-size: 0.75rem;
    font-weight: bold;
}

::v-deep(#description h6) {
    font-size: 0.625rem;
    font-weight: bold;
}
</style>
