<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {formatDate} from "date-fns";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    slots: {
        type: Object,
        required: true
    },
});

</script>

<template>
    <AppLayout title="Unavailable Slots">
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Unavailable Slots
                </h2>
                <div class="ml-auto">
                    <a :href="route('admin.unavailable-slots.create')">Add Slot</a>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 grid grid-cols-1 gap-2">
            <div v-if="!slots.data.length">
                <p>No slots at this time</p>
            </div>
                <div v-for="slot in slots.data" :key="slot.id" class="bg-white shadow-sm sm:rounded-lg">
                    <a
                        class="p-6 bg-white border-b border-gray-200 block"
                        :href="route('admin.unavailable-slots.edit', slot.id)"
                    >
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">
                                {{ formatDate(slot.startAt, 'dd/MM/yyyy hh:mm a') }} -
                                {{ formatDate(slot.endAt, 'dd/MM/yyyy hh:mm a') }}
                            </h2>
                        </div>
                    </a>
                </div>
        </div>
    </AppLayout>
</template>
