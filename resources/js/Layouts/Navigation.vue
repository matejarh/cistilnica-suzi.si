<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { router } from '@inertiajs/vue3';
import MobileNavigation from '@/Components/Navigation/MobileNavigation.vue';
import DesktopNavigation from '@/Components/Navigation/DesktopNavigation.vue';

const showingNavigationDropdown = ref(false);

const navigationLinks = [
    { name: 'Domov', route: 'public.home' },
    { name: 'O nas', route: 'public.about' },
    { name: 'Ponudba', route: 'public.offers' },
    { name: 'Kontakt', route: 'public.contact' },
];

// Close the dropdown when clicking outside
const handleClickOutside = (event) => {
    const dropdown = document.querySelector('.responsive-nav-menu');
    const hamburger = document.querySelector('.hamburger-button');
    if (
        dropdown &&
        !dropdown.contains(event.target) &&
        hamburger &&
        !hamburger.contains(event.target)
    ) {
        showingNavigationDropdown.value = false;
    }
};

const logout = () => {
    console.log('Logging out...');
    router.post(route('logout'));
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="">
        <nav class="bg-primary/70 border-b border-primary-light z-50 backdrop-blur-md relative w-full top-0">
            <DesktopNavigation
                :navigation-links="navigationLinks"
                :showing-navigation-dropdown="showingNavigationDropdown" />

            <MobileNavigation
                v-if="showingNavigationDropdown"
                :navigation-links="navigationLinks"
                :showing-navigation-dropdown="showingNavigationDropdown" />
        </nav>
    </div>
</template>
