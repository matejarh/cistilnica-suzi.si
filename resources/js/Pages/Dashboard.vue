<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';
import { shallowRef } from 'vue';

import TagOutlineIcon from '@/Icons/TagOutlineIcon.vue';
import ChatBubbleBottomCenterTextIcon from '@/Icons/ChatBubbleBottomCenterTextIcon.vue';
import UsersOutlineIcon from '@/Icons/UsersOutlineIcon.vue';
import UserIcon from '@/Icons/UserIcon.vue';

const links = shallowRef([
    { name: 'Akcije', href: route('promotions.index'), icon: TagOutlineIcon },
    { name: 'Poizvedbe', href: route('inquiries.index'), icon: ChatBubbleBottomCenterTextIcon },
    { name: 'Naročniki', href: route('subscribers.index'), icon: UsersOutlineIcon },
    { name: 'Profil', href: route('profile.show'), icon: UserIcon },
]);
</script>

<template>
    <SiteLayout title="Dashboard">
<!--         <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-primary/40 backdrop-blur-xs overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 p-6">

                        <!-- Admin Link Card  -->
                        <div v-for="link in links" :key="link.name" class="bg-primary-dark/60 overflow-hidden shadow-sm sm:rounded-lg">
                            <a :href="link.href" class="p-6 text-center text-neutral-light hover:bg-primary/50 flex flex-col items-center justify-center h-full">
                                <component :is="link.icon" class="w-12 h-12 mx-auto mb-4 text-neutral-light" />
                                <h3 class="text-lg font-semibold text-neutral-light mb-2">
                                    {{ link.name }}
                                </h3>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
