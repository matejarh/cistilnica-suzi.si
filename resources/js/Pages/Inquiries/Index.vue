<script setup>
import AdminNav from '@/Components/AdminNav.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import InquiryCard from './Partials/InquiryCard.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { trim } from 'lodash';
import Paginator from '@/Components/Paginator.vue';

const props = defineProps({
    inquiries: Object,
    filters: Object,
})

const form = ref({
    search: props.filters.search,
    status: props.filters.status,
    deleted: props.filters.deleted,
    per_page: props.filters.per_page,
})

const debouncedHandler = debounce(() => {
    form.value.search = trim(form.value.search)
    router.get(route('inquiries.index'), pickBy(form.value), {
        preserveState: true,
        preserveScroll: true,
    });
}, 500);

watch(form, debouncedHandler, { deep: true });

const reset = () => {
    form.value = mapValues(form.value, () => null);
};
</script>

<template>
    <SiteLayout title="Poizvedbe" description="Pregled, urejanje in brisanje akcij Čistilnice Suzi"
        keywords="upravljanje, akcije, čistilnica, suzi, urejanje, brisanje">

        <div class="py-8 md:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                <AdminNav />

                <!-- Filters -->
                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <form>
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                            <!-- Search Input -->
                            <div class="flex-1">
                                <input type="search" @reset="reset" v-model="form.search"
                                    placeholder="Išči po poizvedbah..."
                                    class="w-full px-4 py-2 border border-primary text-neutral-dark rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary focus:border-primary" />
                            </div>

                            <!-- Status Filter -->
                            <div class="flex sm:ml-4">
                                <select v-model="form.status"
                                    class="w-full px-4 py-2 border border-primary text-neutral-dark rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary focus:border-primary">
                                    <option  disabled>-- izberi --</option>
                                    <option selected value="">Vsi statusi</option>
                                    <option value="pending">V obdelavi</option>
                                    <option value="completed">Zaključeno</option>
                                    <option value="cancelled">Preklicano</option>
                                </select>
                            </div>

                            <!-- Deleted Filter -->
                            <div class="flex sm:ml-4">
                                <select v-model="form.deleted"
                                    class="w-full px-4 py-2 border border-primary text-neutral-dark rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary focus:border-primary">
                                    <option disabled>-- izberi --</option>
                                    <option selected value="">Vse poizvedbe</option>
                                    <option :value="false">Neizbrisane</option>
                                    <option :value="true">Izbrisane</option>
                                </select>
                            </div>

                            <!-- Records On page -->
                            <div class="flex sm:ml-4">
                                <select v-model="form.per_page"
                                    class="w-full px-4 py-2 border border-primary text-neutral-dark rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary focus:border-primary">
                                    <option disabled>-- izberi --</option>
                                    <option value="6">6</option>
                                    <option value="9">9</option>
                                    <option selected value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="48">48</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-primary-dark">Poizvedbe</h2>
                    <div v-if="$page.props.inquiries.total > 0" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <InquiryCard v-for="inquiry in $page.props.inquiries.data" :key="inquiry.id"
                                :inquiry="inquiry" />
                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        Trenutno ni nobene poizvedbe.
                    </div>
                    <Paginator :links="$page.props.inquiries.links" :for-each-side="3" class="mt-4" />
                </div>
            </div>
        </div>
    </SiteLayout>
</template>
