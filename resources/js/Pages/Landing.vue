<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
import DryCleaning from '@/Components/DryCleaning.vue';
import LaundryService from '@/Components/LaundryService.vue';
import IroningService from '@/Components/IroningService.vue';
import SubscribeSection from '@/Components/SubscribeSection.vue';

const appName = import.meta.env.VITE_APP_NAME;
</script>

<template>
    <SiteLayout title="Dobrodošli" description="Čistilnica Suzi - brezhibna čistoča za vaše perilo"
        keywords="čistilnica, suzi, brezhibna, čistoča, perilo, pranje, kemično čiščenje">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-primary-light leading-tight">
                Dobrodošli
            </h2>
        </template> -->

        <div class="py-6 md:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 md:space-y-12">
                <div
                    class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <HeroSection />
                </div>
                <div
                    class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <DryCleaning />
                </div>
                <div
                    class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <LaundryService />

                </div>
                <div
                    class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <IroningService />

                </div>
                <div
                    class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">

                    <SubscribeSection />
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
