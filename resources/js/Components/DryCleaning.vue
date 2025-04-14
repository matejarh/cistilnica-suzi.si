<script setup>
import DryCleaningImage from "@images/banner-kemicna-cistilnica.png";
</script>

<template>
    <section class=" bg-neutral-dark/20 backdrop-blur-md py-4 md:py-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 lg:order-2 lg:mr-auto">
                <h2 class="text-3xl font-extrabold text-primary-light">
                    🧼 Kemična čistilnica
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    "Popolna nega za vaša občutljiva oblačila"
                </p>
                <p class="mt-4 text-neutral-light">
                    Nekatera oblačila potrebujejo posebno nego. S sodobnimi postopki kemičnega čiščenja odstranimo tudi najtrdovratnejše madeže, ne da bi poškodovali tkanino. Vaša oblačila bodo po čiščenju osvežena, mehka in brezhibno čista.
                </p>
                <ul class="mt-4 text-neutral-light list-check">
                    <li>Varno za občutljive tkanine</li>
                    <li>Odstranjevanje madežev brez škode za material</li>
                    <li>Ohranitev barv in strukture blaga</li>
                </ul>
            </div>
            <div class="order-1 lg:order-1 lg:mr-auto">
                <img :src="DryCleaningImage" alt="Kemična čistilnica" class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>

