<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import EnvelopeIcon from '@/Icons/EnvelopeIcon.vue';

defineProps({
    navigationLinks: {
        type: Array,
        required: true
    },
    showingNavigationDropdown: {
        type: Boolean,
        required: true
    }
});
</script>

<template>
    <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 transform scale-y-0"
        enter-to-class="opacity-100 transform scale-y-100"
        leave-active-class="transition-all duration-300 ease-in"
        leave-from-class="opacity-100 transform scale-y-100"
        leave-to-class="opacity-0 transform scale-y-0">
        <div v-if="showingNavigationDropdown"
            class="responsive-nav-menu sm:hidden absolute right-0 z-50 w-56 mt-1 origin-top-right bg-primary divide-y divide-primary-light rounded-md shadow-lg  overflow-hidden">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink
                    v-for="link in navigationLinks"
                    :key="link.route"
                    :href="route(link.route)"
                    :active="route().current(link.route)">
                    {{ link.name }}
                </ResponsiveNavLink>
                <hr class="border-neutral-light mb-4" />
                <ResponsiveNavLink
                    :href="route('public.akcije')"
                    :active="route().current('public.akcije')">
                    <div class="flex items-center">
                        <EnvelopeIcon
                            :is-opened="route().current('public.akcije')"
                            class="w-6 h-6 me-2 text-neutral-light" />
                        <span class="text-neutral-light font-medium">Akcije</span>
                    </div>
                </ResponsiveNavLink>
            </div>
        </div>
    </Transition>
</template>
