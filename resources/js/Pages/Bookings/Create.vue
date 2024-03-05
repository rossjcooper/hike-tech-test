<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import {computed, ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Datepicker from '@vuepic/vue-datepicker';
import {addHours} from "date-fns";

defineProps({
    canLogin: Boolean,
});

const minDate = computed(() => {
    let date = new Date();
    date.setSeconds(0);
    if (date.getMinutes() < 30) {
        date.setMinutes(30);
    } else {
        date = addHours(date, 1);
        date.setMinutes(0);
    }

    return date;
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    vehicleMake: '',
    vehicleModel: '',
    date: '',
})

watch(minDate, (value) => {
    if (!!value && !form.date) {
        form.date = new Date(value);
    }
}, {
    immediate: true
});

const handleSubmit = () => {
    form.post(route('bookings.store'));
}

</script>

<template>
    <Head title="New Booking"/>

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                  class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')"
                      class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Log in
                </Link>
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8 bg-gray-50">
            <div class="flex flex-col items-center justify-center space-y-6">
                <h1 class="text-4xl font-bold text-gray-900">New Booking</h1>
                <form @submit.prevent="form.post(route('bookings.store'))">
                    <div>
                        <label for="name">Name</label>
                        <input v-model="form.name" placeholder="Joe Bloggs" type="text" id="name" name="name"
                               class="block w-full mt-1 rounded-sm focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"/>
                        <input-error :message="form.errors.name"/>
                    </div>

                    <div>
                        <label for="email">Email</label>
                        <input v-model="form.email" placeholder="joe@example.com" type="email" id="email" name="email"
                               class="block w-full mt-1 rounded-sm focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"/>
                        <input-error :message="form.errors.email"/>
                    </div>

                    <div>
                        <label for="phone">Phone</label>
                        <input v-model="form.phone" placeholder="0123456789" type="tel" id="phone" name="phone"
                               class="block w-full mt-1 rounded-sm focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"/>
                        <input-error :message="form.errors.phone"/>
                    </div>

                    <div>
                        <label for="vehicleMake">Vehicle Make</label>
                        <input v-model="form.vehicleMake" placeholder="Tesla" type="text" id="vehicleMake"
                               name="vehicleMake"
                               class="block w-full mt-1 rounded-sm focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"/>
                        <input-error :message="form.errors.vehicleMake"/>
                    </div>

                    <div>
                        <label for="vehicleModel">Vehicle Model</label>
                        <input v-model="form.vehicleModel" placeholder="Model Y" type="text" id="vehicleModel"
                               name="vehicleModel"
                               class="block w-full mt-1 rounded-sm focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"/>
                        <input-error :message="form.errors.vehicleModel"/>
                    </div>

                    <div>
                        <label for="date">Date</label>
                        <Datepicker
                            v-model="form.date"
                            name="date"
                            :minutes-increment="30"
                            :min-date="minDate"
                            :min-time="{hours: 9, minutes: 0}"
                            :max-time="{hours: 17, minutes: 0}"
                            :disabled-week-days="[0, 6]"
                            :minutes-grid-increment="30"
                            format="dd/MM/yyyy HH:mm"
                        />
                        <input-error :message="form.errors.date"/>
                    </div>

                    <div>
                        <PrimaryButton class="my-2" type="submit">Submit</PrimaryButton>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
