<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';

// Get promotions from the page props
const { promotions } = usePage().props;

const showModal = ref(false);

const newPromotionForm = useForm({
    title: '',
    description: '',
});

// State for managing promotions
const promotionList = ref(promotions || []);

const handleCreatePromotion = () => {
    // Logic to handle creating a new promotion
    // This could involve sending a request to the server
    // and updating the promotionList accordingly
    console.log('Creating new promotion:', newPromotionForm);
    showModal.value = false;
};
</script>

<template>

    <SiteLayout title="Upravljanje promocij" description="Pregled, urejanje in brisanje promocij Čistilnice Suzi"
        keywords="upravljanje, promocije, čistilnica, suzi, urejanje, brisanje">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Page Header -->
                <div class="bg-primary overflow-hidden shadow-xl sm:rounded-lg bg-opacity-60 backdrop-blur-sm p-6">
                    <h1 class="text-3xl font-bold text-neutral-light">Upravljanje promocij</h1>
                    <p class="text-neutral-light mt-2">
                        Tukaj lahko pregledate, urejate ali izbrišete obstoječe promocije.
                    </p>
                    <div class="mt-4">
                        <button @click="showModal = true"
                            class="px-4 py-2 bg-primary-light text-white rounded-lg hover:bg-primary">
                            Dodaj novo promocijo
                        </button>

                    </div>
                </div>

                <!-- Promotions List -->
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800">Seznam promocij</h2>
                    <div v-if="promotionList.length" class="mt-4 space-y-4">
                        <div v-for="promotion in promotionList" :key="promotion.id" class="border-b pb-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ promotion.title }}</h3>
                            <p class="text-gray-600">{{ promotion.description }}</p>
                            <div class="mt-2 flex space-x-4">
                                <inertia-link :href="route('promotions.edit', promotion.id)"
                                    class="text-blue-500 hover:underline">
                                    Uredi
                                </inertia-link>
                                <inertia-link :href="route('promotions.destroy', promotion.id)" method="delete"
                                    class="text-red-500 hover:underline">
                                    Izbriši
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        Trenutno ni dodanih promocij.
                    </div>
                </div>
            </div>
        </div>

        <DialogModal v-model:show="showModal" title="Dodaj novo promocijo">
            <template #content>
                <form @submit.prevent="handleCreatePromotion">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Naslov</label>
                        <input type="text" id="title" v-model="newPromotionForm.title"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Opis</label>
                        <textarea id="description" v-model="newPromotionForm.description"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="showModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Prekliči
                        </button>
                        <button type="submit"
                            class="ml-2 px-4 py-2 bg-primary-light text-white rounded-lg hover:bg-primary">
                            Shrani
                        </button>
                    </div>
                </form>
            </template>
            <template #footer>
                <button @click="showModal = false"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Zapri
                </button>
            </template>
        </DialogModal>
    </SiteLayout>
</template>
