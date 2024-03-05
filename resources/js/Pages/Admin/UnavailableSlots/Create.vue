<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {addHours, formatDate} from "date-fns";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import Datepicker from "@vuepic/vue-datepicker";

const form = useForm({
    startAt: new Date(),
    endAt: addHours(new Date(), 1),
});

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
            @submit.prevent="form.post(route('admin.unavailable-slots.store'))"
        >
            <div>
                <label for="startAt">Start Date</label>
                <Datepicker
                    v-model="form.startAt"
                    name="startAt"
                    format="dd/MM/yyyy HH:mm"
                />
                <input-error :message="form.errors.startAt"/>
            </div>
            <div>
                <label for="startAt">End Date</label>
                <Datepicker
                    v-model="form.endAt"
                    name="startAt"
                    format="dd/MM/yyyy HH:mm"
                />
                <input-error :message="form.errors.endAt"/>
            </div>
            <div>
                <PrimaryButton>Save</PrimaryButton>
            </div>
        </form>
    </AppLayout>
</template>
