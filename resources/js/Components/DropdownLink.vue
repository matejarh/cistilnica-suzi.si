<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    as: String,
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-neutral-light hover:bg-primary-dark/70 focus:outline-hidden focus:bg-primary-dark/80 transition duration-150 ease-in-out">
            <slot />
        </button>

        <a v-else-if="as =='a'" :href="href" class="block px-4 py-2 text-sm leading-5 text-neutral-light hover:bg-primary-dark/70 focus:outline-hidden focus:bg-primary-dark/80 transition duration-150 ease-in-out">
            <slot />
        </a>

        <Link v-else :href="href" class="block px-4 py-2 text-sm leading-5 text-neutral-light hover:bg-primary-dark/70 focus:outline-hidden focus:bg-primary-dark/80 transition duration-150 ease-in-out">
            <slot />
        </Link>
    </div>
</template>
