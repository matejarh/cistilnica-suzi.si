<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import { ref } from 'vue'
import HeroSection from '@/Components/HeroSection.vue';

const appName = import.meta.env.VITE_APP_NAME;
</script>

<template>
    <SiteLayout title="Dobrodošli">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-primary-light leading-tight">
                Dobrodošli
            </h2>
        </template>

        <div class="py-6 md:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-primary overflow-hidden shadow-xl shadow-primary sm:rounded-lg bg-opacity-60 backdrop-blur-sm mb-24">
                    <HeroSection />

                </div>
            </div>
        </div>
    </SiteLayout>
</template>
