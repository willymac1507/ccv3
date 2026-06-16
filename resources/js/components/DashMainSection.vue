<script setup lang="ts">
import { ref } from 'vue';
import DashAppointments from '@/components/DashAppointments.vue';
import DashCalendar from '@/components/DashCalendar.vue';

const parentDate = ref(new Date());

const meetings = [
    {
        id: 1,
        date: 'January 10th, 2022',
        time: '5:00 PM',
        datetime: '2022-01-10T17:00',
        name: 'Leslie Alexander',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        location: 'Starbucks',
    },
    {
        id: 2,
        date: 'January 12th, 2022',
        time: '3:00 PM',
        datetime: '2022-01-12T15:00',
        name: 'Michael Foster',
        imageUrl:
            'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        location: 'Tim Hortons',
    },
    {
        id: 3,
        date: 'January 12th, 2022',
        time: '5:00 PM',
        datetime: '2022-01-12T17:00',
        name: 'Dries Vincent',
        imageUrl:
            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        location: 'Costa Coffee at Braehead',
    },
    {
        id: 4,
        date: 'January 14th, 2022',
        time: '10:00 AM',
        datetime: '2022-01-14T10:00',
        name: 'Lindsay Walton',
        imageUrl:
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        location: 'Silverburn',
    },
    {
        id: 5,
        date: 'January 14th, 2022',
        time: '12:00 PM',
        datetime: '2022-01-14T12:00',
        name: 'Courtney Henry',
        imageUrl:
            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        location: 'The Glasgow Green',
    },
];
</script>

<template>
    <div>
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">
            Today's Appointments
        </h2>
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-16">
            <DashCalendar v-model="parentDate"></DashCalendar>
            <DashAppointments :meetings="meetings" />
        </div>
    </div>
</template>

<style scoped></style>
