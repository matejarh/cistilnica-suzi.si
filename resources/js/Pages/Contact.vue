<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import ContactIllustration from '@images/kontakt.png';
</script>

<template>
    <SiteLayout title="Kontakt"
                description="Kontaktirajte Čistilnico Suzi za brezhibno čistočo vašega perila"
                keywords="čistilnica, suzi, kontakt, perilo, pranje, kemično čiščenje">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-primary overflow-hidden shadow-xl shadow-primary sm:rounded-lg bg-opacity-60 backdrop-blur-sm">
                    <div class="p-6 lg:p-8 space-y-8 lg:space-y-12">
                        <!-- Title -->
                        <h1 class="font-heading text-4xl font-bold text-neutral-light text-center">Kontakt</h1>
                        <p class="font-sans text-lg text-neutral-light text-center">
                            Stopite v stik z nami za vsa vprašanja ali dodatne informacije.
                        </p>

                        <!-- Contact Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <!-- Contact Info -->
                            <div class="order-2 md-order-1 space-y-4 text-neutral-light">
                                <h2 class="text-2xl font-bold text-primary-light">Kontaktni podatki</h2>
                                <ul class="space-y-2">
                                    <li><strong>Podjetje:</strong> Čistilnica Suzi, Suzana Simonetič s.p.</li>
                                    <li>
                                        <strong>Naslov:</strong>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination=Železniška+cesta+5,+4248+Lesce"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="text-white hover:underline">
                                            Železniška cesta 5, 4248 Lesce
                                        </a>
                                    </li>
                                    <li>
                                        <strong>GSM:</strong>
                                        <a href="tel:041277643" class="text-white hover:underline">
                                            041 277 643
                                        </a>
                                    </li>
                                    <li>
                                        <strong>Telefon:</strong>
                                        <a href="tel:045315051" class="text-white hover:underline">
                                            04 531 50 51
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Illustration -->
                            <div class="order 1 md:order-2 flex justify-center">
                                <img :src="ContactIllustration" alt="Kontakt ilustracija" class="w-full max-w-md rounded-lg shadow-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
