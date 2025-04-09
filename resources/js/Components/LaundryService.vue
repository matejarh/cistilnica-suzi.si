<script setup>
import LaundryImage from "../../images/banner-pralnica-perila.png";
</script>

<template>
    <section class="py-12 bg-primary-dark bg-opacity-20 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
            <div class="order-2 lg:order-1 lg:mr-auto">
                <h2 class="text-3xl font-extrabold text-primary-dark dark:text-primary-light">
                    👕 Pralnica perila
                </h2>
                <p class="mt-4 text-lg text-neutral-light">
                    "Brezhibna čistoča, popolna svežina"
                </p>
                <p class="mt-4 text-neutral-light">
                    Naj bo vaše perilo vedno brezhibno! S profesionalnimi pralnimi sredstvi in prilagojenimi programi pranja poskrbimo za čistočo in svežino vseh vrst tkanin – od vsakdanjih oblačil do posteljnine in brisač.
                </p>
                <ul class="mt-4 text-neutral-light">
                    <li>✅ Ekološka in hipoalergena čistila</li>
                    <li>✅ Pranje po meri (občutljive tkanine, bela perila itd.)</li>
                    <li>✅ Hitro in učinkovito pranje</li>
                </ul>
            </div>
            <div class="order-1 lg:order-2 lg:mr-auto">
                <img :src="LaundryImage" alt="Pralnica perila" class="w-full h-auto" />
            </div>
        </div>
    </section>
</template>
