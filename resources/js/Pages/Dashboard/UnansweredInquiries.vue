<script setup>
import InquiryCard from '@/Pages/Inquiries/Partials/InquiryCard.vue';
import ReplyDialog from '../Inquiries/Partials/ReplyDialog.vue';
import { ref } from 'vue';
import DeleteConfirmationDialog from '../Inquiries/Partials/DeleteConfirmationDialog.vue';


const emit = defineEmits(['reply', 'delete']);

const showReplyDialog = ref(false);
const showDeleteDialog = ref(false);
const currentInquiry = ref(null);

const handleReplyDialogClose = () => {
    showReplyDialog.value = false;
    currentInquiry.value = null;
};

const handleReplyDialogOpen = (inquiry) => {
    showReplyDialog.value = true;
    currentInquiry.value = inquiry;
};

const handleDeleteConfirmation = (inquiry) => {
    currentInquiry.value = inquiry;
    showDeleteDialog.value = true;
};
const handleDeleteDialogClose = () => {
    currentInquiry.value = null;
    showDeleteDialog.value = false;
};



</script>

<template>
    <div class="bg-neutral-light/65 backdrop-blur-xs shadow-lg sm:rounded-lg p-6">
        <h2 class="text-xl font-bold text-primary-dark">Neodgovorjene poizvedbe</h2>
        <div v-if="$page.props.unanswered_inquiries.length > 0" class="mt-4 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <InquiryCard
                    v-for="inquiry in $page.props.unanswered_inquiries"
                    :key="inquiry.id"
                    :inquiry="inquiry"
                    @send="handleReplyDialogOpen"
                    @delete="handleDeleteConfirmation"
                />
            </div>
        </div>
        <div v-else class="text-gray-600">
            Trenutno ni neodgovorjenih poizvedb.
        </div>
        <ReplyDialog :show="showReplyDialog" :inquiry="currentInquiry" @close="handleReplyDialogClose" />

        <DeleteConfirmationDialog :show="showDeleteDialog" :inquiry="currentInquiry"
            @close="handleDeleteDialogClose" @clearInquiryToDelete="currentInquiry = null" />
    </div>
</template>
