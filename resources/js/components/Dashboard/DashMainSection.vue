<script setup lang="ts">
import type { Ref } from 'vue';
import { inject, ref } from 'vue';
import DashAppointments from '@/components/Dashboard/DashAppointments.vue';
import DashCalendar from '@/components/Dashboard/DashCalendar.vue';

interface Props {
    date: string | number | Date;
}

const meetings: Array<any> | undefined = inject('appointments');

const props = defineProps<Props>();

const parentDate: Ref = ref(new Date(props.date));
</script>

<template>
    <div>
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">
            Today's Appointments
        </h2>
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-16">
            <DashCalendar v-model="parentDate"></DashCalendar>
            <DashAppointments v-model="parentDate" :meetings="meetings" />
        </div>
    </div>
</template>

<style scoped></style>
