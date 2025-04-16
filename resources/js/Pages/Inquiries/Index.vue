<script setup>
import AdminNav from '@/Components/AdminNav.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import InquiryCard from './Partials/InquiryCard.vue';

</script>

<template>
    <SiteLayout title="Poizvedbe" description="Pregled, urejanje in brisanje akcij Čistilnice Suzi"
        keywords="upravljanje, akcije, čistilnica, suzi, urejanje, brisanje">

        <div class="py-8 md:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <AdminNav />


                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-primary-dark">Poizvedbe</h2>
                    <div v-if="$page.props.inquiries.total > 0" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <InquiryCard v-for="inquiry in $page.props.inquiries.data" :key="inquiry.id"
                            :inquiry="inquiry" />
                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        Trenutno ni nobene poizvedbe.
                    </div>
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
