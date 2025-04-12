<script setup>
import ArrowUpIcon from "@/Icons/ArrowUpIcon.vue";

const props = defineProps({
  scrollTop: Number,
});

const scrollToTop = () => {
  document.getElementById("main").scrollTo(0, 0);
};
</script>

<template>
  <div class="overflow-hidden">
    <Transition
      enter-active-class="ease-out duration-300"
      enter-from-class="opacity-0 translate-y-16 sm:scale-95"
      enter-to-class="opacity-100 translate-y-0 sm:scale-100"
      leave-active-class="ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0 sm:scale-100"
      leave-to-class="opacity-0 translate-y-16 sm:scale-95"
    >
      <div class="absolute bottom-1 right-6 z-50" v-show="scrollTop > 200">
          <button
            @click="scrollToTop"
            class="inline-flex justify-center p-0 text-primary-400 rounded-sm cursor-pointer hover:text-primary-900 bg-primary/40 hover:bg-primary/70 shadow-xs  transition ease-in-out duration-300 hover:-translate-y-1"
          >
            <ArrowUpIcon class="w-12 h-12 lg:w-12 lg:h-12" />
          </button>
      </div>
    </Transition>
  </div>
</template>
