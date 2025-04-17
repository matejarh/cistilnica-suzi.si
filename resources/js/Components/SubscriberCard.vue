<script setup>
import PaperAirplaneIcon from '@/Icons/PaperAirplaneIcon.vue';
import PencileSquareIcon from '@/Icons/PencileSquareIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';
import Tooltip from './Tooltip.vue';
import Badge from './Badge.vue';

defineProps({
    subscriber: {
        type: Object,
        required: true,
    },
});

defineEmits(['send', 'delete']);


</script>

<template>
    <div class="border-b pb-4 bg-neutral-light/60 rounded-lg shadow-lg p-4 relative">
        <div class="absolute inset-x-0 -top-2 flex justify-center">
            <Badge :color="subscriber?.status_color">
                {{ subscriber?.is_subscribed ? 'Aktiven' : 'Neaktiven' }}
            </Badge>
        </div>
        <div class="mb-2 flex justify-between border-b border-neutral-dark pb-2">
            <div class="flex space-x-4">
                <Tooltip :text="`Pošlji sporočilo na ${subscriber?.email}`" location="top">
                    <button @click="$emit('send', subscriber)"
                        class="text-primary hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        <PaperAirplaneIcon class="w-5 h-5 " />

                    </button>
                </Tooltip>

                <!-- <Tooltip text="Uredi" location="top">
                    <button @click="$emit('edit', subscriber)"
                        class="text-primary hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                        <PencileSquareIcon class="w-5 h-5 " />

                    </button>
                </Tooltip> -->
            </div>
            <Tooltip text="Izbriši" location="top">
                <button @click="$emit('delete', subscriber)"
                    class="text-red-500 hover:underline hover:-translate-y-0.5 transition ease-in-out duration-150 cursor-pointer">
                    <TrashIcon class="w-5 h-5 " />
                </button>
            </Tooltip>
        </div>

        <h3 class="text-lg font-semibold text-neutral-dark">{{ subscriber?.email }}</h3>

    </div>
</template>

