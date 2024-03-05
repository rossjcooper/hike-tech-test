<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {formatDate} from "date-fns";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    bookings: {
        type: Object,
        required: true
    },
    date: {
        type: String,
        required: false
    }

})

const form = useForm({
    date: props.date ?? '',
})

const clearForm = () => {
    form.reset();
    form.date = '';
    submitForm();
}

const submitForm = () => {
    form.submit('get', route('admin.bookings.index'))
}

</script>

<template>
    <AppLayout title="Bookings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bookings
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 grid grid-cols-1 gap-2">
            <div class="">
                <form action="" @submit.prevent="submitForm"
                      class="w-full bg-white shadow p-4 flex gap-2">
                    <input type="date" v-model="form.date">
                    <PrimaryButton>Search</PrimaryButton>
                    <SecondaryButton @click="clearForm">Clear</SecondaryButton>
                </form>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <div v-if="!bookings.data.length">
                    <p>No bookings at this time</p>
                </div>
                <div v-for="booking in bookings.data" :key="booking.id">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                                        {{ booking.name }}
                                    </h2>
                                    <p class="text-gray-600">
                                        <a class="underline text-indigo-500" :href="`mailto: ${booking.email}`" >{{ booking.email }}</a> |
                                        <a class="underline text-indigo-500" :href="`tel: ${booking.phone}`">{{ booking.phone }}</a>
                                    </p>
                                    <p class="text-gray-600">{{ booking.vehicleMake }} - {{ booking.vehicleModel }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">{{ formatDate(booking.startAt, 'dd/MM/yyyy hh:mm a') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
