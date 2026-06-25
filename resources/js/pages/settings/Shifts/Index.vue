<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import type { ComputedRef } from 'vue';
import { capitalize } from 'vue';
import { computed, ref } from 'vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';

const page = usePage();
const studentShifts: ComputedRef = computed(() => page.props.auth.user.shifts);
const currentShifts = ref(studentShifts.value.map(makeArray));

function makeArray(shift: any) {
    return [
        shift.day,
        {
            uuid: shift.uuid,
            start: shift.startTime,
            end: shift.endTime,
            break: shift.breakTime,
            breakDuration: shift.duration,
        },
    ];
}

const days: Array<string> = [
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
    'sunday',
];

interface Form {
    [key: string]: object;
    monday: {
        [key: string]: string;
        uuid: string;
        day: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    tuesday: {
        [key: string]: string;
        uuid: string;
        day: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    wednesday: {
        [key: string]: string;
        uuid: string;
        day: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    thursday: {
        [key: string]: string;
        uuid: string;
        day: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    friday: {
        [key: string]: string;
        uuid: string;
        day: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    saturday: {
        [key: string]: string;
        uuid: string;
        day: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    sunday: {
        [key: string]: string;
        uuid: string;
        day: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
}

const form = ref(
    useForm<Form>({
        monday: {
            day: currentShifts.value[0][0],
            uuid: currentShifts.value[0][1].uuid,
            start: currentShifts.value[0][1].start,
            end: currentShifts.value[0][1].end,
            break: currentShifts.value[0][1].break,
            breakDuration: currentShifts.value[0][1].breakDuration,
        },
        tuesday: {
            day: currentShifts.value[1][0],
            uuid: currentShifts.value[1][1].uuid,
            start: currentShifts.value[1][1].start,
            end: currentShifts.value[1][1].end,
            break: currentShifts.value[1][1].break,
            breakDuration: currentShifts.value[1][1].breakDuration,
        },
        wednesday: {
            day: currentShifts.value[2][0],
            uuid: currentShifts.value[2][1].uuid,
            start: currentShifts.value[2][1].start,
            end: currentShifts.value[2][1].end,
            break: currentShifts.value[2][1].break,
            breakDuration: currentShifts.value[2][1].breakDuration,
        },
        thursday: {
            day: currentShifts.value[3][0],
            uuid: currentShifts.value[3][1].uuid,
            start: currentShifts.value[3][1].start,
            end: currentShifts.value[3][1].end,
            break: currentShifts.value[3][1].break,
            breakDuration: currentShifts.value[3][1].breakDuration,
        },
        friday: {
            day: currentShifts.value[4][0],
            uuid: currentShifts.value[4][1].uuid,
            start: currentShifts.value[4][1].start,
            end: currentShifts.value[4][1].end,
            break: currentShifts.value[4][1].break,
            breakDuration: currentShifts.value[4][1].breakDuration,
        },
        saturday: {
            day: currentShifts.value[5][0],
            uuid: currentShifts.value[5][1].uuid,
            start: currentShifts.value[5][1].start,
            end: currentShifts.value[5][1].end,
            break: currentShifts.value[5][1].break,
            breakDuration: currentShifts.value[5][1].breakDuration,
        },
        sunday: {
            day: currentShifts.value[6][0],
            uuid: currentShifts.value[6][1].uuid,
            start: currentShifts.value[6][1].start,
            end: currentShifts.value[6][1].end,
            break: currentShifts.value[6][1].break,
            breakDuration: currentShifts.value[6][1].breakDuration,
        },
    }),
);

for (const day of days) {
    console.log(day);
    console.log(form.value[day]);
}
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
    <form @submit.prevent="form.patch('/settings/shifts')" class="space-y-6">
        <div class="grid grid-cols-5 text-sm">
            <div class="col-start-2 px-4 text-left">Start</div>
            <div class="px-4 text-left">End</div>
            <div class="px-4 text-left">Break</div>
            <div class="text-center">Duration</div>
        </div>
        <div v-for="day in days" :key="day" class="grid grid-cols-5 text-sm">
            <div>{{ capitalize(day) }}</div>
            <input
                type="time"
                :name="day + 'Start'"
                :id="day + 'Start'"
                class="col-start-2 px-4"
                v-model="form[day].start"
            />
            <input
                type="time"
                :name="day + 'End'"
                :id="day + 'End'"
                class="px-4"
                v-model="form[day].end"
            />
            <input
                type="time"
                :name="day + 'Break'"
                :id="day + 'Break'"
                class="px-4"
                v-model="form[day].break"
            />
            <input
                type="text"
                :name="day + 'BreakDuration'"
                :id="day + 'BreakDuration'"
                placeholder="minutes"
                class="text-center"
                v-model="form[day].breakDuration"
            />
        </div>
        <Button class="mt-2 cursor-pointer" type="submit">Update</Button>
    </form>
</template>
