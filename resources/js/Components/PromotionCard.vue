<script setup>
import PaperAirplaneIcon from '@/Icons/PaperAirplaneIcon.vue';
import PencileSquareIcon from '@/Icons/PencileSquareIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';

defineProps({
    promotion: {
        type: Object,
        required: true,
    },
});

defineEmits(['send', 'edit', 'delete']);
</script>

<template>
    <div class="border-b pb-4 bg-neutral-light/60 rounded-lg shadow-lg p-4">

        <div class="mb-2 flex justify-between border-b border-neutral-dark pb-2">
            <div class="flex space-x-4">
                <button @click="$emit('send', promotion)"
                    class="text-blue-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                    <PaperAirplaneIcon class="w-5 h-5 " />

                </button>
                <button @click="$emit('edit', promotion)" class="text-blue-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                    <PencileSquareIcon class="w-5 h-5 " />

                </button>
            </div>
            <button @click="$emit('delete', promotion)" class="text-red-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                <TrashIcon class="w-5 h-5 " />
            </button>
        </div>

        <h3 class="text-lg font-semibold text-gray-800">{{ promotion.name }}</h3>
        <p class="text-gray-600" v-html="promotion.description.replace(/\n/g, '<br>')"></p>
        <p class="text-gray-500">
            Začetni datum: {{ new Date(promotion.start_date).toLocaleDateString('sl-SI')
            }}<br />
            Končni datum: {{ new Date(promotion.end_date).toLocaleDateString('sl-SI') }}
        </p>
    </div>
</template>
