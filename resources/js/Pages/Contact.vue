<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import ContactIllustration from '@images/kontakt.png';
import { computed, ref } from 'vue';

const workingHours = ref([
    { day: 'Ponedeljek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Torek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Sreda', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Četrtek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Petek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Sobota', hours: '08:00 – 12:00' },
    { day: 'Nedelja', hours: 'Zaprta' }
]);

const isDuringWorkingHours = computed(() => {
    const now = new Date();
    const currentDay = now.toLocaleDateString('sl-SI', { weekday: 'long' }).charAt(0).toUpperCase() + now.toLocaleDateString('sl-SI', { weekday: 'long' }).slice(1);
    const currentTime = now.getHours() * 60 + now.getMinutes();

    const todayHours = workingHours.value.find(day => day.day === currentDay)?.hours;

    if (!todayHours || todayHours === 'Zaprta') {
        return false;
    }

    const timeRanges = todayHours.split(',').map(range => range.trim());
    return timeRanges.some(range => {
        const [start, end] = range.split('–').map(time => {
            const [hours, minutes] = time.trim().split(':').map(Number);
            return hours * 60 + minutes;
        });
        return currentTime >= start && currentTime <= end;
    });
});

const contactDetails = ref({
    company: 'Čistilnica Suzi, Suzana Simonetič s.p.',
    address: 'Železniška cesta 5, 4248 Lesce',
    phone: '041 277 643',
    landline: '04 531 50 51'
});
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
                        <p class="font-sans text-lg text-center" :class="isDuringWorkingHours ? 'text-green-300': 'text-red-300'">Čistilnica Suzi je trenutno {{ isDuringWorkingHours ? 'odprta' : 'zaprta' }}</p>

                        <!-- Contact Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <!-- Contact Info -->
                            <div class="order-2 md:order-1 space-y-4 text-neutral-light">
                                <h2 class="text-2xl font-bold text-primary-light">Kontaktni podatki</h2>
                                <ul class="space-y-2">
                                    <li><strong>Podjetje: </strong>{{ contactDetails.company }}</li>
                                    <li>
                                        <strong>Naslov: </strong>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination=Železniška+cesta+5,+4248+Lesce"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="text-white hover:underline">
                                            {{ contactDetails.address }}
                                        </a>
                                    </li>
                                    <li>
                                        <strong>GSM: </strong>
                                        <a href="tel:{{ contactDetails.phone }}" class="text-white hover:underline">
                                            {{ contactDetails.phone }}
                                        </a>
                                    </li>
                                    <li>
                                        <strong>Telefon: </strong>
                                        <a href="tel:{{ contactDetails.landline }}" class="text-white hover:underline">
                                            {{ contactDetails.landline }}
                                        </a>
                                    </li>
                                </ul>

                                <!-- Working Hours -->
                                <h2 class="text-2xl font-bold text-primary-light">Delovni čas</h2>
                                <ul class="space-y-2">
                                    <li v-for="(hour, index) in workingHours" :key="index">
                                        <strong>{{ hour.day }}:</strong> {{ hour.hours }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Illustration -->
                            <div class="order-1 md:order-2 flex justify-center">
                                <img :src="ContactIllustration" alt="Kontakt ilustracija" class="w-full max-w-md rounded-lg shadow-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
