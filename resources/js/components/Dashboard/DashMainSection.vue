<script lang="ts" setup>
import type { Ref } from 'vue';
import { inject, ref } from 'vue';
import DashAppointments from '@/components/Dashboard/DashAppointments.vue';
import DashCalendar from '@/components/Dashboard/DashCalendar.vue';

interface Props {
    date: string | number | Date;
}

const props = defineProps<Props>();

const parentDate: Ref = ref(new Date(props.date));
</script>

<template>
    <div>
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">
            Today's Appointments
        </h2>
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-16">
            <DashCalendar v-model="parentDate" />
            <DashAppointments v-model="parentDate" />
        </div>
    </div>
</template>

<style scoped></style>
