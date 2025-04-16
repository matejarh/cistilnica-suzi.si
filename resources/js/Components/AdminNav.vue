<!-- filepath: g:\PROJECTS\cistilnica-suzi\cistilnica-suzi.si\resources\js\Components\AdminToolbar.vue -->
<script setup>
import { computed } from 'vue';
import TagOutlineIcon from '@/Icons/TagOutlineIcon.vue';
import ChatBubbleBottomCenterTextIcon from '@/Icons/ChatBubbleBottomCenterTextIcon.vue';
import UsersOutlineIcon from '@/Icons/UsersOutlineIcon.vue';
import UserIcon from '@/Icons/UserIcon.vue';
import { Link } from '@inertiajs/vue3';

// Define the links with route names instead of hrefs
const links = [
    { name: 'Akcije', route: 'promotions.index', icon: TagOutlineIcon },
    { name: 'Poizvedbe', route: 'inquiries.index', icon: ChatBubbleBottomCenterTextIcon },
    { name: 'Naročniki', route: 'subscribers.index', icon: UsersOutlineIcon },
    { name: 'Profil', route: 'profile.show', icon: UserIcon },
];

// Add active state to each link
const linksWithActiveState = computed(() =>
    links.map((link) => ({
        ...link,
        isActive: route().current(link.route), // Check if the current route matches the link's route name
    }))
);
</script>

<template>
    <div class="bg-primary/40 backdrop-blur-xs overflow-hidden shadow-xl sm:rounded-lg">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 p-6">
            <!-- Admin Link Card -->
            <div
                v-for="link in linksWithActiveState"
                :key="link.name"
                :class="[
                    'overflow-hidden shadow-sm sm:rounded-lg',
                    link.isActive ? 'bg-primary/70' : 'bg-primary-dark/60',
                ]"
            >
                <Link
                    :href="route(link.route)"
                    class="p-2 text-center text-neutral-light hover:bg-primary/50 flex flex-col items-center justify-center h-full"
                >
                    <component :is="link.icon" class="w-8 h-8 mx-auto text-neutral-light" />
                    <h3
                        :class="[
                            'text-md font-semibold',
                            link.isActive ? 'text-white' : 'text-neutral-light',
                        ]"
                    >
                        {{ link.name }}
                    </h3>
                </Link>
            </div>
        </div>
    </div>
</template>
