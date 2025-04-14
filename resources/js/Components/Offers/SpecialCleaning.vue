<script setup>
import SpecialCleaningIcon from "@/Icons/SpecialCleaningIcon.vue";
</script>

<template>
    <section class="py-4 md:p-4 bg-neutral-dark/30 backdrop-blur-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 md:order-2">
                <h2 class="text-3xl font-extrabold text-primary-light">
                    🧼 Prevzem posebnih kosov za čiščenje
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    Strokovna obdelava zahtevnejših materialov v sodelovanju s čistilnico Labod.
                </p>
                <ul class="list-check ms-4 mt-4 text-neutral-light">
                    <li>Preproge.</li>
                    <li>Usnjeni izdelki.</li>
                    <li>Poročne in svečane obleke.</li>
                </ul>
                <p class="mt-4 text-neutral-light">
                    Skrbno prevzamemo vaše kose, jih odpeljemo na strokovno obdelavo in vam jih nato vrnemo čiste in pripravljene za uporabo.
                </p>
            </div>
            <div class="order-1 md:order-1">
                <SpecialCleaningIcon class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>
