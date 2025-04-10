<script setup>
import LaundryIcon from "@/Icons/LaundryIcon.vue";
</script>

<template>
    <section class="py-12 bg-primary-dark bg-opacity-30 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 md:order-1">
                <h2 class="text-3xl font-extrabold text-primary-light">
                    🧺 Pranje in likanje perila
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    Poskrbimo za brezhibno čistočo in nego vašega perila.
                </p>
                <ul class="list-disc list-outside ms-4 mt-4 text-neutral-light">
                    <li>Hotelsko in gostinsko perilo: profesionalno čiščenje in likanje posteljnega perila, brisač, prtov.</li>
                    <li>Osebno perilo: perilo posameznikov ali družin – z občutkom za detajle in nego materialov.</li>
                    <li>Pranje prešitih odej, blazin, nadvložkov, zaves: nežno a učinkovito čiščenje večjih in občutljivejših kosov.</li>
                </ul>
            </div>
            <div class="order-1 md:order-2">
                <LaundryIcon class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>
