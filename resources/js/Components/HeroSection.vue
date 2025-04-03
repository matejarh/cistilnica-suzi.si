<script setup>
import Hero from "../../images/banner-hero.png";
</script>

<template>
    <section class="bg-primary-100 dark:bg-primary-900 pt-20 sm:pt-10">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 md:grid-cols-12">
            <div class="order-1 lg:mr-auto place-self-center text-center md:col-span-7">
                <h1
                    class="font-heading max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-center text-primary-800 ">
                    Čistilnica Suzi<br /><small>brezhibna čistoča za vaše perilo</small>
                </h1>
                <p
                    class="font-sans max-w-2xl mb-6 font-light text-neutral-light lg:mb-8 md:text-lg lg:text-xl text-center ">
                    Kemično čiščenje, pranje in likanje z vrhunsko skrbnostjo.<br> Zaupajte nam svoje perilo in uživajte v popolni svežini!
                </p>
                <inertia-link :href="route('prices')"
                    class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-primary-light focus:ring-4 focus:ring-primary">
                    Oglej si ponudbo
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </inertia-link>
                <inertia-link :href="route('contact')"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-neutral-light border border-neutral-light rounded-lg hover:bg-neutral-light hover:text-neutral-dark focus:ring-4 focus:ring-neutral-light ">
                    Kje nas najdete
                </inertia-link>
            </div>
            <div class="order-2 mb-6 lg:mb-0 lg:mt-0 md:col-span-5 md:flex">
                <img :src="Hero" alt="hero1" class="rounded-lg"
                    style="filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5))" />
            </div>
        </div>
    </section>
</template>
