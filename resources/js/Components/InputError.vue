<script setup>
import ExclamationIcon from '@/Icons/ExclamationIcon.vue';

defineProps({
    message: String,
});
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-red-400 bg-white/75 p-2 rounded-md shadow-xs flex items-center">
            <ExclamationIcon class="w-5 h-5 me-2 text-red-500" />
            {{ message }}
        </p>
    </div>
</template>
