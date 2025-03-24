<script setup>
import Banner from '@/Components/Banner.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'

</script>

<template>
    <SiteLayout title="Dobrodošli">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    Landing Page
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
