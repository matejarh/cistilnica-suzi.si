<script setup>
import DryCleaningIcon from "@/Icons/DryCleaningIcon.vue";
</script>

<template>
    <section class="py-12 bg-neutral-dark bg-opacity-30 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 md:order-2">
                <h2 class="text-3xl font-extrabold text-primary-light">
                    🧥 Kemično čiščenje
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    Strokovno čiščenje za občutljive tkanine in oblačila.
                </p>
                <ul class="list-disc list-outside ms-4 mt-4 text-neutral-light">
                    <li>Zimski plašči, moške in ženske obleke: strokovno čiščenje, ki ohrani obliko in barvo.</li>
                    <li>Delovna oblačila: čiščenje trdovratnih madežev.</li>
                    <li>Volnene zavese in drugi občutljivi materiali: poseben postopek za podaljšano življenjsko dobo tkanin.</li>
                </ul>
            </div>
            <div class="order-1 md:order-1">
                <DryCleaningIcon class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>
