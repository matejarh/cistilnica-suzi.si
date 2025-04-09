<script setup>
import IroningImage from "../../images/banner-likalnica.png";
</script>

<template>
    <section class="py-12 bg-neutral-dark bg-opacity-20 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 lg:order-2 lg:mr-auto ">
                <h2 class="text-3xl font-extrabold text-primary dark:text-primary-light">
                    🧺 Likalnica perila
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    "Popolno zlikano perilo, brez gub"
                </p>
                <p class="mt-4 text-neutral-light">
                    Ni vam treba več skrbeti za likanje! S profesionalnimi likalnimi napravami poskrbimo, da bodo vaša oblačila, posteljnina in ostali tekstili vedno brez gub in pripravljeni za uporabo.
                </p>
                <ul class="mt-4 text-neutral-light">
                    <li>✅ Hitro in natančno likanje</li>
                    <li>✅ Nežno likanje občutljivih materialov</li>
                    <li>✅ Popoln videz brez napora</li>
                </ul>
            </div>
            <div class="order-1 lg:order-1 lg:mr-auto">
                <img :src="IroningImage" alt="Likalnica perila" class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>

