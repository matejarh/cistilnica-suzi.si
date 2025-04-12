<script setup>
import LinenIcon from "@/Icons/LinenIcon.vue";
</script>

<template>
    <section class="py-12 bg-primary-dark/30 backdrop-blur-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 md:order-1">
                <h2 class="text-3xl font-extrabold text-primary-light">
                    🛏️ Najem posteljnine
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    Priročna rešitev za apartmaje, sobe, vikende ali občasne potrebe.
                </p>
                <ul class="list-disc list-outside ms-4 mt-4 text-neutral-light">
                    <li>Prevleke za blazine, odeje, rjuhe ter brisače.</li>
                    <li>Redno vzdrževanje, pranje in likanje posteljnine.</li>
                    <li>Vedno pripravljena za uporabo.</li>
                </ul>
            </div>
            <div class="order-1 md:order-2">
                <LinenIcon class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>
