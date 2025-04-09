<script setup>
import ArrowRightIcon from "@/Icons/ArrowRightIcon.vue";
import Hero from "../../images/banner-hero.png";
import ButtonPrimary from "./ButtonPrimary.vue";
import ButtonSecondary from "./ButtonSecondary.vue";
</script>

<template>
    <section class=" pt-20 sm:pt-10">
        <div class="grid max-w-screen-xl px-4 py-6 mx-auto lg:gap-8 xl:gap-0 lg:py-16 md:grid-cols-12">
            <div class="order-2 lg:order-1 lg:mr-auto place-self-center text-center md:col-span-7">
                <h1
                    class="font-heading max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-center text-primary-800 ">
                    Čistilnica Suzi<br /><small>brezhibna čistoča za vaše perilo</small>
                </h1>
                <p
                    class="font-sans max-w-2xl mb-6 font-light text-neutral-light lg:mb-8 md:text-lg lg:text-xl text-center ">
                    Kemično čiščenje, pranje in likanje z vrhunsko skrbnostjo.<br> Zaupajte nam svoje perilo in uživajte v popolni svežini!
                </p>
                <div class="space-y-4 md:space-y-0">

                    <ButtonPrimary as="link" :href="route('prices')">
                        Oglej si ponudbo
                        <ArrowRightIcon class="w-5 h-5 ml-2 -mr-1" />
                    </ButtonPrimary>

                    <ButtonSecondary as="link" :href="route('contact')">
                        Kje nas najdete
                    </ButtonSecondary>
                </div>
            </div>
            <div class="order-1 lg:order-2 mb-6 lg:mb-0 lg:mt-0 md:col-span-5 md:flex">
                <img :src="Hero" alt="hero1" class="h-max-content"
                    style="filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5))" />
            </div>
        </div>
    </section>
</template>
