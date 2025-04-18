<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import AdminNav from '@/Components/AdminNav.vue';
import UnansweredInquiries from './Dashboard/UnansweredInquiries.vue';
</script>

<template>
    <SiteLayout title="Dashboard">
<!--         <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template> -->

        <div class="py-8 md:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <AdminNav />
                <UnansweredInquiries />
            </div>
        </div>
    </SiteLayout>
</template>
