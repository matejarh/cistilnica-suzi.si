<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import EnvelopeIcon from '@/Icons/EnvelopeIcon.vue';
import { router } from '@inertiajs/vue3';

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

const logout = () => {
    console.log('Logging out...');
    router.post(route('logout'));
};
</script>

<template>
    <Transition enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 transform scale-y-0" enter-to-class="opacity-100 transform scale-y-100"
        leave-active-class="transition-all duration-300 ease-in" leave-from-class="opacity-100 transform scale-y-100"
        leave-to-class="opacity-0 transform scale-y-0">
        <div v-if="showingNavigationDropdown"
            class="responsive-nav-menu sm:hidden absolute right-0 z-50 w-56 mt-1 origin-top-right bg-primary divide-y divide-primary-light rounded-md shadow-lg  overflow-hidden">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink v-for="link in navigationLinks" :key="link.route" :href="route(link.route)"
                    :active="route().current(link.route)">
                    {{ link.name }}
                </ResponsiveNavLink>
                <hr class="border-neutral-light mb-4" />
                <ResponsiveNavLink :href="route('public.akcije')" :active="route().current('public.akcije')">
                    <div class="flex items-center">
                        <EnvelopeIcon :is-opened="route().current('public.akcije')"
                            class="w-6 h-6 me-2 text-neutral-light" />
                        <span class="text-neutral-light font-medium">Akcije</span>
                    </div>
                </ResponsiveNavLink>
                <div class="" v-if="$page.props.auth.user">
                    <hr class="border-neutral-light mb-4" />
                    <div class="block px-4 py-2 text-xs text-neutral-light">
                        Upravljanje z računom
                    </div>

                    <ResponsiveNavLink :href="route('profile.show')">
                        Moj profil
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                        API Tokens
                    </ResponsiveNavLink>

                    <div class="border-t border-neutral-light" />

                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                        <ResponsiveNavLink as="button">
                            Odjava
                        </ResponsiveNavLink>
                    </form>
                </div>
            </div>
        </div>
    </Transition>
</template>
