<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import ContactIllustration from '@images/kontakt.png';
import { onMounted, ref } from 'vue';

// Working hours
const workingHours = ref([
    { day: 'Ponedeljek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Torek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Sreda', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Četrtek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Petek', hours: '08:00 – 12:00, 15:00 – 18:00' },
    { day: 'Sobota', hours: '08:00 – 12:00' },
    { day: 'Nedelja', hours: 'Zaprta' }
]);

// Contact details
const contactDetails = ref({
    company: 'Čistilnica Suzi, Suzana Simonetič s.p.',
    address: 'Železniška cesta 5, 4248 Lesce',
    phone: '041 277 643',
    landline: '04 531 50 51'
});

// Current time and working hours status
const now = ref(new Date());
const isDuringWorkingHours = ref(false);

// Update the current time and check if it's within working hours
const updateNow = () => {
    now.value = new Date();

    const currentDay = now.value.toLocaleDateString('sl-SI', { weekday: 'long' })
        .charAt(0).toUpperCase() + now.value.toLocaleDateString('sl-SI', { weekday: 'long' }).slice(1);
    const currentTime = now.value.getHours() * 60 + now.value.getMinutes();

    const todayHours = workingHours.value.find(day => day.day === currentDay)?.hours;

    if (!todayHours || todayHours === 'Zaprta') {
        isDuringWorkingHours.value = false;
        return;
    }

    const timeRanges = todayHours.split(',').map(range => range.trim());
    isDuringWorkingHours.value = timeRanges.some(range => {
        const [start, end] = range.split('–').map(time => {
            const [hours, minutes] = time.trim().split(':').map(Number);
            return hours * 60 + minutes;
        });
        return currentTime >= start && currentTime <= end;
    });
};

// Initialize the time updater
onMounted(() => {
    updateNow();
    setInterval(updateNow, 60000); // Update every minute
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

                        <!-- Contact Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <!-- Contact Info -->
                            <div class="order-2 md:order-1 space-y-4 text-neutral-light">
                                <h2 class="text-2xl font-bold text-primary-light">Kontaktni podatki</h2>
                                <ul class="space-y-2">
                                    <li><strong>Podjetje:</strong> {{ contactDetails.company }}</li>
                                    <li>
                                        <strong>Naslov:</strong>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination=Železniška+cesta+5,+4248+Lesce"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="text-white hover:underline">
                                            {{ contactDetails.address }}
                                        </a>
                                    </li>
                                    <li>
                                        <strong>GSM:</strong>
                                        <a href="tel:{{ contactDetails.phone }}" class="text-white hover:underline">
                                            {{ contactDetails.phone }}
                                        </a>
                                    </li>
                                    <li>
                                        <strong>Telefon:</strong>
                                        <a href="tel:{{ contactDetails.landline }}" class="text-white hover:underline">
                                            {{ contactDetails.landline }}
                                        </a>
                                    </li>
                                </ul>

                                <!-- Working Hours -->
                                <div class="flex items-baseline space-x-4">
                                    <h2 class="text-2xl font-bold text-primary-light">Delovni čas</h2>
                                    <p :class="isDuringWorkingHours ? 'text-green-300' : 'text-red-300'">
                                        Trenutno smo {{ isDuringWorkingHours ? 'odprti' : 'zaprti' }}
                                    </p>
                                </div>
                                <ul class="space-y-2">
                                    <li v-for="(hour, index) in workingHours" :key="index">
                                        <strong>{{ hour.day }}:</strong> {{ hour.hours }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Illustration -->
                            <div class="order-1 md:order-2 flex justify-center">
                                <img :src="ContactIllustration" alt="Kontakt ilustracija" class="w-full max-w-md ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
