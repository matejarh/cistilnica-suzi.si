<script setup>
import ExclamationIcon from '@/Icons/ExclamationIcon.vue';

defineProps({
    message: String,
});
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-red-600 dark:text-red-400 bg-white p-2 rounded-md shadow-sm flex items-center bg-opacity-75">
            <ExclamationIcon class="w-5 h-5 me-2 text-red-500" />
            {{ message }}
        </p>
    </div>
</template>
