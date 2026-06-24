<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import type { ComputedRef } from 'vue';
import { computed, ref } from 'vue';
import Heading from '@/components/Heading.vue';

const page = usePage();
const studentShifts: ComputedRef = computed(() => page.props.auth.user.shifts);
const currentShifts = ref(studentShifts.value.map(makeArray));


function makeArray(shift: any) {
    return [ shift.day, {
        start: shift.startTime,
        end: shift.endTime,
        break: shift.breakTime,
        breakDuration: shift.duration,
    }]
}

const form = ref(
    useForm({
        monday: {
            start: currentShifts.value[0][1].start,
            end: currentShifts.value[0][1].end,
            break: currentShifts.value[0][1].break,
            breakDuration: currentShifts.value[0][1].breakDuration,
        },
        tuesday: {
            start: currentShifts.value[1][1].start,
            end: currentShifts.value[1][1].end,
            break: currentShifts.value[1][1].break,
            breakDuration: currentShifts.value[1][1].breakDuration,
        },
        wednesday: {
            start: currentShifts.value[2][1].start,
            end: currentShifts.value[2][1].end,
            break: currentShifts.value[2][1].break,
            breakDuration: currentShifts.value[2][1].breakDuration,
        },
        thursday: {
            start: currentShifts.value[3][1].start,
            end: currentShifts.value[3][1].end,
            break: currentShifts.value[3][1].break,
            breakDuration: currentShifts.value[3][1].breakDuration,
        },
        friday: {
            start: currentShifts.value[4][1].start,
            end: currentShifts.value[4][1].end,
            break: currentShifts.value[4][1].break,
            breakDuration: currentShifts.value[4][1].breakDuration,
        },
        saturday: {
            start: currentShifts.value[5][1].start,
            end: currentShifts.value[5][1].end,
            break: currentShifts.value[5][1].break,
            breakDuration: currentShifts.value[5][1].breakDuration,
        },
        sunday: {
            start: currentShifts.value[6][1].start,
            end: currentShifts.value[6][1].end,
            break: currentShifts.value[6][1].break,
            breakDuration: currentShifts.value[6][1].breakDuration,
        },
}));
//
// const currentShifts = reactive<Reactive<any>>({
//     days: {
//         day: null,
//         start: null,
//         end: null,
//         break: null,
//         breakDuration: null,
//     },
// });

</script>

<template>
    <Head title="Availability" />

    <h1 class="sr-only">Availability</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            variant="small"
            title="Availability"
            description="Select the shifts you are working"
        />
    </div>
    <form @submit.prevent class="space-y-6">
        <div class="grid grid-cols-5 grid-rows-8 gap-y-4 text-sm">
            <div class="col-start-2 text-left px-4">Start</div>
            <div class="text-left px-4">End</div>
            <div class="text-left px-4">Break</div>
            <div class="text-center">Duration</div>
            <div class="row-start-2">Monday</div>
            <input
                type="time"
                name="mondayStart"
                id="mondayStart"
                class="col-start-2 px-4"
                v-model="form.monday.start"
            />
            <input
                type="time"
                name="mondayEnd"
                id="mondayEnd"
                class="col-start-3 px-4"
                v-model="form.monday.end"
            />
            <input
                type="time"
                name="mondayBreak"
                id="mondayBreak"
                class="col-start-4 px-4"
                v-model="form.monday.break"
            />
            <input
                type="text"
                class="px-4 text-center placeholder:text-center"
                name="mondayBreakDuration"
                id="mondayBreakDuration"
                placeholder="minutes"
                v-model="form.monday.breakDuration"
            />
            <div class="row-start-3">Tuesday</div>
            <div class="row-start-4">Wednesday</div>
            <div class="row-start-5">Thursday</div>
            <div class="row-start-6">Friday</div>
            <div class="row-start-7">Saturday</div>
            <div class="row-start-8">Sunday</div>
        </div>
    </form>
</template>

<style scoped></style>
