<script setup>
import { ref, watchEffect } from 'vue';
import { usePage } from '@inertiajs/vue3';
import SuccessIcon from '@/Icons/SuccessIcon.vue';
import DangerIcon from '@/Icons/DangerIcon.vue';
import CloseIcon from '@/Icons/CloseIcon.vue';

const page = usePage();
const show = ref(true);
const style = ref('success');
const message = ref('');

watchEffect(async () => {
    style.value = page.props.jetstream.flash?.bannerStyle || 'success';
    message.value = page.props.jetstream.flash?.banner || '';
    show.value = true;

    if (message.value) {
        setTimeout(() => {
            show.value = false;
        }, 10000);
    }
});
</script>

<template>
    <div>
        <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 -translate-y-4"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-4">
            <div v-if="show && message" :class="{ 'bg-green-700': style == 'success', 'bg-red-700': style == 'danger' }"
                class="absolute top-0 z-[1000] w-full">
                <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between flex-wrap">
                        <div class="w-0 flex-1 flex items-center min-w-0">
                            <span class="flex p-2 rounded-lg"
                                :class="{ 'bg-green-600': style == 'success', 'bg-red-600': style == 'danger' }">
                                <SuccessIcon class="size-5 text-white" v-if="style == 'success'" />
                                <DangerIcon class="size-5 text-white" v-if="style == 'danger'" />
                            </span>

                            <p class="ms-3 font-medium text-sm text-white truncate" v-html="message"></p>
                        </div>

                        <div class="shrink-0 sm:ms-3">
                            <button type="button"
                                class="-me-1 flex p-2 rounded-md focus:outline-none sm:-me-2 transition"
                                :class="{ 'hover:bg-green-600 focus:bg-green-600': style == 'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }"
                                aria-label="Dismiss" @click.prevent="show = false">
                                <CloseIcon class="size-5 text-white" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>
