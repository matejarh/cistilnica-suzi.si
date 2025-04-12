<script setup>
import Features from '@/Components/Features.vue';
import ONasHeroSection from '@/Components/ONasHeroSection.vue';
import Slogan from '@/Components/Slogan.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import { ref } from 'vue'

</script>

<template>
    <SiteLayout title="Dobrodošli">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-primary-light leading-tight">
                O nas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg  backdrop-blur-xs">
                    <div class="">

                        <ONasHeroSection />
                        <Features />
                        <Slogan />
                    </div>
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
