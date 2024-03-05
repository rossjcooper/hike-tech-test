<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {addHours, formatDate, parseISO} from "date-fns";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import Datepicker from "@vuepic/vue-datepicker";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    slot: {
        type: Object,
        required: true
    },
});

const form = useForm({
    startAt: parseISO(props.slot.data.startAt),
    endAt: parseISO(props.slot.data.endAt),
});

const onDelete = () => {
    if (confirm('Are you sure you want to delete this slot?')) {
        form.delete(route('admin.unavailable-slots.delete', props.slot.data.id));
    }
}
</script>

<template>
    <AppLayout title="Unavailable Slots">
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Unavailable Slots
                </h2>
            </div>
        </template>

        <form
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 grid grid-cols-1 gap-2"
            @submit.prevent="form.put(route('admin.unavailable-slots.update', props.slot.data.id))"
        >
            <div>
                <label for="startAt">Start Date</label>
                <Datepicker
                    v-model="form.startAt"
                    name="startAt"
                    format="dd/MM/yyyy hh:mm a"
                />
                <input-error :message="form.errors.startAt"/>
            </div>
            <div>
                <label for="startAt">End Date</label>
                <Datepicker
                    v-model="form.endAt"
                    name="startAt"
                    format="dd/MM/yyyy hh:mm a"
                />
                <input-error :message="form.errors.endAt"/>
            </div>
            <div class="flex gap-2">
                <PrimaryButton>Save</PrimaryButton>
                <DangerButton @click="onDelete">Delete</DangerButton>
            </div>
        </form>
    </AppLayout>
</template>
