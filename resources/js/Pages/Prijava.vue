<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import { ref } from 'vue'

</script>

<template>
    <SiteLayout title="Dobrodošli">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-primary-light leading-tight">
                Prijava na promocije in akcije
            </h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-primary overflow-hidden shadow-xl shadow-primary sm:rounded-lg bg-opacity-60 backdrop-blur-sm">

                    <div class="p-6 lg:p-8 space-y-4 lg:space-y-6">

                        <h1 class="font-heading text-4xl font-bold text-neutral-light">Prijava na promocije in akcije</h1>
                        <p class="font-sans text-lg text-neutral-light">Nekaj besedila, z obrazložitvijo zakaj se prijaviti..</p>
                        <p class="font-sans text-lg text-neutral-light">Obrazec za vnos emaila</p>
                    </div>
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
