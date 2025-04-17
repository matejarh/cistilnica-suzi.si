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
import SelectInput from '@/Components/SelectInput.vue';
import Filters from './Partials/Filters.vue';
import ReplyDialog from './Partials/ReplyDialog.vue';

const props = defineProps({
    inquiries: Object,
    filters: Object,
})

const showReplyDialog = ref(false);
const showDeleteDialog = ref(false);
const inquiryToReply = ref(null);
const inquiryToDelete = ref(null);

const form = ref({
    search: props.filters.search,
    status: props.filters.status ? props.filters.status : "",
    deleted: props.filters.deleted ? props.filters.deleted : "",
    per_page: props.filters.per_page ? props.filters.per_page : 12,
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

const handleReply = (inquiry) => {
    console.log('handleReply', inquiry);
    inquiryToReply.value = inquiry;
    showReplyDialog.value = true;
};
const handleDelete = (inquiry) => {
    inquiryToDelete.value = inquiry;
    showDeleteDialog.value = true;
};
const handleEdit = (inquiry) => {
    router.get(route('inquiries.edit', inquiry.id), {}, {
        preserveState: true,
        preserveScroll: true,
    });
};
const handleReplyDialogClose = () => {
    inquiryToReply.value = null;
    showReplyDialog.value = false;
};
const handleDeleteDialogClose = () => {
    inquiryToDelete.value = null;
    showDeleteDialog.value = false;
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
                    <Filters v-model:filters="form" @reset="reset" />
                </div>


                <div class="bg-neutral-light/65  backdrop-blur-xs shadow-xs sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-primary-dark">Poizvedbe</h2>
                    <div v-if="$page.props.inquiries.total > 0" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <InquiryCard v-for="inquiry in $page.props.inquiries.data" :key="inquiry.id"
                                :inquiry="inquiry" @send="handleReply" @delete="handleDelete" @edit="handleEdit" />
                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        <span v-if="form.search || form.status || form.deleted" class="text-gray-500">
                            Trenutno ni nobene poizvedbe, ki bi ustrezala kriterijem iskanja.
                        </span>
                        <span v-else class="text-gray-500">
                            Trenutno ni nobene poizvedbe.
                        </span>
                    </div>
                    <Paginator :links="$page.props.inquiries.links" :for-each-side="3" class="mt-4" />
                </div>
            </div>
        </div>
        <ReplyDialog :show="showReplyDialog" :inquiry="inquiryToReply" @close="handleReplyDialogClose" />
    </SiteLayout>
</template>
