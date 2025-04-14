<script setup>
import IroningImage from "@images/banner-likalnica.png";
</script>

<template>
    <section class=" bg-neutral-dark/20 backdrop-blur-md py-4 md:py-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6  lg:px-0 lg:pr-8 grid md:grid-cols-12 gap-8 items-center">
            <div class="order-2 lg:order-2 lg:mr-auto md:col-span-7">
                <h2 class="text-3xl font-extrabold text-primary-light">
                    🧺 Likalnica perila
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    "Popolno zlikano perilo, brez gub"
                </p>
                <p class="mt-4 text-neutral-light">
                    Ni vam treba več skrbeti za likanje! S profesionalnimi likalnimi napravami poskrbimo, da bodo vaša oblačila, posteljnina in ostali tekstili vedno brez gub in pripravljeni za uporabo.
                </p>
                <ul class="mt-4 text-neutral-light list-check">
                    <li>Hitro in natančno likanje</li>
                    <li>Nežno likanje občutljivih materialov</li>
                    <li>Popoln videz brez napora</li>
                </ul>
            </div>
            <div class="order-1 lg:order-1 lg:mr-auto md:col-span-5">
                <img :src="IroningImage" alt="Likalnica perila" class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>

