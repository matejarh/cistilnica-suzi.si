<script setup>
import ArrowRightIcon from "@/Icons/ArrowRightIcon.vue";
import Hero from "@images/banner-hero.png";
import Logo from "@images/logoSuzi150.png";
import ButtonPrimary from "../ButtonPrimary.vue";

defineEmits(['scrollToContact']);
</script>

<template>
    <section class=" pt-20 sm:pt-10">
        <div class="grid max-w-(--breakpoint-xl) px-4 lg:pl-8 py-6 mx-auto lg:gap-8 xl:gap-0 lg:py-16 md:grid-cols-12">
            <div class="order-2 lg:order-2 lg:mr-auto place-self-center text-center md:col-span-7">
                <h1
                    class="font-heading max-w-2xl mb-4 text-3xl font-extrabold tracking-tight leading-none md:text-3xl xl:text-4xl text-center text-primary-800 ">
                    <img :src="Logo" alt="Čistilnica Suzi Logo" class="mx-auto h-24 md:h-24 mb-4 opacity-90">

                    <small>najboljša izbira za vaše potrebe čiščenja</small>
                </h1>
                <p
                    class="font-sans max-w-2xl mb-6 font-light text-neutral-light lg:mb-8 md:text-lg lg:text-xl text-center ">
                    V <b>Čistilnici Suzi</b> že desetletja skrbimo za brezhibno čistočo vašega perila, tekstila in
                    oblačil. Naša ponudba zajema širok spekter storitev, namenjenih tako posameznikom
                    kot tudi podjetjem – s poudarkom na kakovosti, natančnosti ter zanesljivosti.
                </p>
                <div class="space-y-4 md:space-y-0">
                    <ButtonPrimary as="button" @click="$emit('scrollToContact', 'povprasevanje')">
                        Pošljite povpraševanje
                        <ArrowRightIcon class="w-5 h-5 ml-2 -mr-1 rotate-90" />
                    </ButtonPrimary>
                </div>

            </div>
            <div class="order-1 lg:order-1 mb-6 lg:mb-0 lg:mt-0 md:col-span-5 md:flex md:items-center">
                <img :src="Hero" alt="hero1" class="h-max-content"
                    style="filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5))" />
            </div>
        </div>
    </section>
</template>
