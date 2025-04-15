<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import UnsubscribeForm from '@/Pages/Akcije/Partials/UnsubscribeForm.vue';
</script>

<template>
    <SiteLayout
        title="Odjava od promocij in akcij"
        description="Odjavite se od promocij in akcij Čistilnice Suzi"
        keywords="odjava, promocije, akcije, čistilnica, suzi"
    >
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 md:space-y-12">

                <!-- Banner Section -->
                <div class="bg-primary/60 overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <div class="p-6 lg:p-8 flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                        <div class="flex-1">
                            <h1 class="font-heading text-4xl font-bold text-neutral-light">
                                Odjava od promocij in akcij
                            </h1>
                            <p class="font-sans text-lg text-neutral-light mt-4">
                                Odjavite se od naših promocij in akcij ter prenehajte prejemati obvestila o najnovejših ponudbah in ugodnostih.
                            </p>
                        </div>
                        <div class="flex-1">
                            <img
                                src="@images/odjava_na_akcij.png"
                                alt="Odjava od akcij"
                                class="rounded-lg"
                            />
                        </div>
                    </div>
                </div>

                <!-- Unsubscribe Section -->
                <div class="overflow-hidden shadow-xl shadow-primary sm:rounded-lg backdrop-blur-xs">
                    <UnsubscribeForm class="rounded-lg" />
                </div>

            </div>
        </div>
    </SiteLayout>
</template>
