<!-- filepath: g:\PROJECTS\cistilnica-suzi\cistilnica-suzi.si\resources\js\Components\Filters.vue -->
<template>
    <form>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <!-- Search Input -->
            <div class="flex-1">
                <input
                    type="search"
                    v-model="filters.search"
                    @reset="$emit('reset')"
                    placeholder="Išči po poizvedbah..."
                    class="w-full px-4 py-2 text-sm border-2 border-primary text-neutral-dark rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-primary focus:border-primary"
                />
            </div>

            <!-- Status Filter -->
            <div class="flex sm:ml-4">
                <SelectInput
                    v-model="filters.status"
                    :options="statusOptions"
                    placeholder="-- izberi status --"
                />
            </div>

            <!-- Deleted Filter -->
            <div class="flex sm:ml-4">
                <SelectInput
                    v-model="filters.deleted"
                    :options="deletedOptions"
                    placeholder="-- izberi --"
                />
            </div>

            <!-- Records Per Page -->
            <div class="flex sm:ml-4">
                <SelectInput
                    v-model="filters.per_page"
                    :options="perPageOptions"
                    placeholder="-- izberi --"
                />
            </div>
        </div>
    </form>
</template>

<script setup>
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    filters: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['update:filters', 'reset']);

const statusOptions = [
    { value: '', label: 'Vsi statusi' },
    { value: 'pending', label: 'V obdelavi' },
    { value: 'completed', label: 'Zaključeno' },
    { value: 'cancelled', label: 'Preklicano' },
];

const deletedOptions = [
    { value: '', label: 'Vse poizvedbe' },
    { value: false, label: 'Neizbrisane' },
    { value: true, label: 'Izbrisane' },
];

const perPageOptions = [
    { value: 6, label: '6' },
    { value: 9, label: '9' },
    { value: 12, label: '12' },
    { value: 24, label: '24' },
    { value: 48, label: '48' },
];
</script>
