<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import LaundryAndIroning from '@/Components/Offers/LaundryAndIroning.vue';
import DryCleaning from '@/Components/Offers/DryCleaning.vue';
import LinenRental from '@/Components/Offers/LinenRental.vue';
import SpecialCleaning from '@/Components/Offers/SpecialCleaning.vue';
import HeroSection from '@/Components/Offers/HeroSection.vue';
</script>

<template>
    <SiteLayout title="Ponudba" description="Čistilnica Suzi - brezhibna čistoča za vaše perilo"
        keywords="čistilnica, suzi, brezhibna, čistoča, perilo, pranje, kemično čiščenje">


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-primary overflow-hidden shadow-xl shadow-primary sm:rounded-lg bg-opacity-60 backdrop-blur-sm">
                    <div class="">
                        <HeroSection />
                        <LaundryAndIroning />
                        <DryCleaning />
                        <LinenRental />
                        <SpecialCleaning />
                    </div>
                </div>
            </div>
        </div>

    </SiteLayout>
</template>
