<script setup>
import ArrowRightIcon from "@/Icons/ArrowRightIcon.vue";
import Hero from "@images/banner-hero.png";
import ButtonPrimary from "./ButtonPrimary.vue";
import ButtonSecondary from "./ButtonSecondary.vue";
import Logo from "@images/logoSuzi150.png";
</script>

<template>
    <section class="">
        <div class="grid max-w-(--breakpoint-xl) px4 md:px-8 py-6 mx-auto lg:gap-8 xl:gap-0 lg:py-16 md:grid-cols-12">
            <div class="order-2 lg:order-1 lg:mr-auto place-self-center text-center md:col-span-7">
                <h1
                    class="font-heading max-w-2xl mb-4 text-3xl font-extrabold tracking-tight leading-none md:text-4xl xl:text-5xl text-center text-primary-800 ">
                    <img :src="Logo" alt="Čistilnica Suzi Logo" class="mx-auto h-24 md:h-32 mb-4 opacity-90">

                    <small>brezhibna čistoča za vaše perilo</small>
                </h1>
                <p
                    class="font-sans max-w-2xl mb-6 font-light text-neutral-light lg:mb-8 md:text-lg lg:text-xl text-center ">
                    Kemično čiščenje, pranje in likanje z vrhunsko skrbnostjo.<br> Zaupajte nam svoje perilo in uživajte v popolni svežini!
                </p>
                <div class="space-y-4 space-x-0 sm:space-y-0 sm:space-x-4 flex flex-col sm:flex-row justify-center mx-4 sm:mx-0">

                    <ButtonSecondary as="link" :href="route('public.contact')">
                        Kje nas najdete
                    </ButtonSecondary>

                    <ButtonPrimary as="link" :href="route('public.offers')">
                        Oglej si ponudbo
                        <ArrowRightIcon class="w-5 h-5 ml-2 -mr-1" />
                    </ButtonPrimary>
                </div>
            </div>
            <div class="order-1 md:order-2 mb-6 md:mb-0 md:mt-0 md:col-span-5 md:flex md:items-center">
                <img :src="Hero" alt="hero1" class="h-max-content"
                    style="filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5))" />
            </div>
        </div>
    </section>
</template>
