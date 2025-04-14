<script setup>
import InfoIcon from '@/Icons/InfoIcon.vue';
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'info',
    },
    title: {
        type: String|null,
        default: null,
    },
    message: {
        type: String,
        default: 'Change a few things up and try submitting again.',
    },
});

const icon = computed(() => {
    switch (props.type) {
        case 'info':
            return InfoIcon;
        case 'success':
            return SuccessCircleIcon;
        case 'warning':
            return WarningIcon;
        case 'error':
            return ErrorIcon;
        default:
            return InfoIcon;
    }
});

const classes = computed(() => {
        switch (props.type) {
            case 'info':
                return 'bg-primary-dark/60 text-neutral-light';
            case 'success':
                return 'bg-green-100 text-green-700';
            case 'warning':
                return 'bg-yellow-100 text-yellow-700';
            case 'error':
                return 'bg-red-100 text-red-700';
            default:
                return 'bg-primary-dark/60 text-neutral-light';
        }
});
</script>

<template>
    <div class="flex items-center text-left p-4 mb-4 text-sm rounded-lg "
        :class="classes"
        role="alert">
        <component :is="icon" class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" />

        <span class="sr-only">{{ type }}</span>
        <div>
            <span class="font-medium" v-if="title">{{ title }}</span>
            <span v-html="message" class="block text-sm ">

            </span>
        </div>
    </div>
</template>
