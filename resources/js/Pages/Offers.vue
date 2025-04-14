<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import LaundryAndIroning from '@/Components/Offers/LaundryAndIroning.vue';
import DryCleaning from '@/Components/Offers/DryCleaning.vue';
import LinenRental from '@/Components/Offers/LinenRental.vue';
import SpecialCleaning from '@/Components/Offers/SpecialCleaning.vue';
import HeroSection from '@/Components/Offers/HeroSection.vue';
import ContactForm from '@/Components/Offers/ContactForm.vue';

const scrollToContactForm = (targetId) => {
    const mainElement = document.getElementById('main');
    const targetElement = document.getElementById(targetId);
    if (mainElement && targetElement) {
        mainElement.scrollTo({
            top: targetElement.offsetTop - mainElement.offsetTop,
            behavior: 'smooth'
        });
    }
};
</script>

<template>
    <SiteLayout title="Ponudba" description="Čistilnica Suzi - brezhibna čistoča za vaše perilo"
        keywords="čistilnica, suzi, brezhibna, čistoča, perilo, pranje, kemično čiščenje">


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 md:space-y-12">
                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <HeroSection @scroll-to-contact="scrollToContactForm" />
                </div>

                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <LaundryAndIroning />
                </div>

                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <DryCleaning />
                </div>

                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <LinenRental />
                </div>

                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <SpecialCleaning />
                </div>

                <div id="povprasevanje"
                    class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <ContactForm />
                </div>
            </div>
        </div>

    </SiteLayout>
</template>
