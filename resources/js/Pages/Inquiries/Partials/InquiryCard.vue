<script setup>
import Badge from '@/Components/Badge.vue';
import Tooltip from '@/Components/Tooltip.vue';
import PaperAirplaneIcon from '@/Icons/PaperAirplaneIcon.vue';
import PencileSquareIcon from '@/Icons/PencileSquareIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';


defineProps({
    inquiry: {
        type: Object,
        required: true,
    },
});

defineEmits(['send', 'edit', 'delete']);
</script>

<template>
    <div class="border-b pb-4 bg-neutral-light/60 rounded-lg shadow-lg p-4 relative space-y-4">
        <div class="absolute inset-x-0 -top-2 flex justify-center">
            <Badge :color="inquiry.status_color">
                {{ inquiry.status }}
            </Badge>
        </div>

        <div class="mb-2 flex justify-between border-b border-neutral-dark pb-2">
            <div class="flex space-x-4">
                <Tooltip text="Odgovori" location="top">
                    <button @click="$emit('send', inquiry)"
                        class="text-primary hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        <PaperAirplaneIcon class="w-5 h-5 " />

                    </button>
                </Tooltip>

<!--                 <Tooltip text="Uredi" location="top">
                    <button @click="$emit('edit', inquiry)"
                        class="text-primary hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        <PencileSquareIcon class="w-5 h-5 " />

                    </button>
                </Tooltip> -->
            </div>
            <Tooltip text="Izbriši" location="top">
                <button @click="$emit('delete', inquiry)"
                    class="text-red-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                    <TrashIcon class="w-5 h-5 " />
                </button>
            </Tooltip>
        </div>

        <div class="flex justify-between">
            <div class="">
                <div class="flex items-center text-sm text-neutral-500 whitespace-nowrap">

                    <!-- <span class="font-medium me-1">Datum: </span> -->
                    {{ new Date(inquiry.created_at).toLocaleDateString('sl-SI') }}
                </div>
                <div class="flex items-center text-sm text-neutral-500 whitespace-nowrap">

                    <!-- <span class="font-medium me-1">Od: </span> -->
                    {{ inquiry.name }}
                </div>
            </div>
            <div class="">

                <div class="flex items-center text-sm text-neutral-500 whitespace-nowrap">

                    <!-- <span class="font-medium me-1">E-pošta: </span> -->
                    <a href="mailto:{{ inquiry.email }}"
                        class="text-neutral-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        {{ inquiry.email }}
                    </a>
                </div>
                <div class="flex items-center text-sm text-neutral-500 whitespace-nowrap">

                    <!-- <span class="font-medium me-1">Telefon: </span> -->
                    <a href="tel:{{ inquiry.phone }}"
                        class="text-neutral-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        {{ inquiry.phone }}
                    </a>
                </div>
            </div>

        </div>
        <h5 class="text-lg font-semibold text-neutral-dark">
            {{ inquiry.subject }}
        </h5>
        <p class="mb-3 font-normal text-neutral-500" v-html="inquiry.message.replace(/\n/g, '<br>')"></p>
        <div class="flex items-center text-sm text-neutral">

        </div>
        <!-- <inertia-link :href="route('inquiries.show', inquiry)"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white  rounded-lg  focus:ring-4 focus:outline-none  bg-primary hover:bg-primary/90 focus:ring-primary/50">
            Podrobnosti
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </inertia-link> -->
    </div>

</template>
