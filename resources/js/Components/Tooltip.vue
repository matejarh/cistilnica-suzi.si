<script setup>
import ApearDisapearFadeTransition from '@/Transitions/ApearDisapearFadeTransition.vue';
import { computed, ref } from 'vue';
const props = defineProps({
    text: String,
    location: {
        default: 'top',
        type: String,
    }
})

const aligmentClasses = computed(() => {
    return {
        'top': '-top-12 left-1/2 -translate-x-1/2 bg-gradient-to-t from-black  to-gray-950',
        'bottom': '-bottom-12 left-1/2 -translate-x-1/2 bg-gradient-to-b from-black  to-gray-950',
        'left': 'right-[120%] top-1/2 -translate-y-1/2   bg-gradient-to-t from-black  to-gray-950',
        'right': '-right-12 bg-gradient-to-t from-black  to-gray-950',
    }[props.location];
})
const arrowAligmentClasses = computed(() => {
    return {
        'top': '-bottom-1 left-1/2 -translate-x-1/2',
        'bottom': '-top-1 left-1/2 -translate-x-1/2',
        'left': '-right-1 bottom-1/2 translate-y-1/2',
        'right': '-left-1',
    }[props.location];
})
const show = ref(false)
</script>
<template>
    <div @mouseover="show = true" @mouseleave="show = false">
        <div class="relative select-none cursor-pointer">
            <slot />
            <ApearDisapearFadeTransition>
                <div v-show="show"
                    :class="aligmentClasses"
                    class="inline-block absolute whitespace-nowrap  transform z-[10000] py-2 px-3 text-sm font-medium text-white  rounded-lg shadow-sm transition-opacity duration-300"
                    >
                    <div class="z-[10001]">
                        {{ text }}

                    </div>
                    <div :class="arrowAligmentClasses" class="absolute w-3 z-0 h-3 rotate-45 bg-black transform  text-lg" />
                </div>

            </ApearDisapearFadeTransition>
        </div>
    </div>

</template>
