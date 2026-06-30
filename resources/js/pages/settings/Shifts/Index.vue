<script lang="ts" setup>
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { split } from 'es-toolkit/compat';
import type { ComputedRef } from 'vue';
import { capitalize } from 'vue';
import { computed, ref } from 'vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { index } from '@/routes/shifts';

interface Page {
    props: {
        errors: object;
        auth: {
            shifts: Array<any>;
        };
    };
}

interface errors {
    monday: {
        breakDuration: string;
    };
    tuesday: {
        breakDuration: string;
    };
    wednesday: {
        breakDuration: string;
    };
    thursday: {
        breakDuration: string;
    };
    friday: {
        breakDuration: string;
    };
    saturday: {
        breakDuration: string;
    };
    sunday: {
        breakDuration: string;
    };

    [key: string]: object;
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Availability',
                href: index(),
            },
        ],
    },
});

const page: Page = usePage();
const errors: ComputedRef | errors = computed(() => page.props.errors);
const studentShifts: ComputedRef = computed(() => page.props.auth.shifts);
const currentShifts = ref(studentShifts.value.map(makeArray));

function makeArray(shift: any) {
    return [
        shift.day,
        {
            uuid: shift.uuid,
            dayNumber: shift.dayNumber,
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

interface shiftFormObject {
    [key: string]: string;
}

interface Form {
    monday: {
        uuid: string;
        day: string;
        dayNumber: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    tuesday: {
        uuid: string;
        day: string;
        dayNumber: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    wednesday: {
        uuid: string;
        day: string;
        dayNumber: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    thursday: {
        uuid: string;
        day: string;
        dayNumber: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    friday: {
        uuid: string;
        day: string;
        dayNumber: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    saturday: {
        uuid: string;
        day: string;
        dayNumber: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };
    sunday: {
        uuid: string;
        day: string;
        dayNumber: string;
        start: string;
        end: string;
        break: string;
        breakDuration: string;
    };

    [key: string]: shiftFormObject;
}

const form = ref(
    useForm<Form>('patch', '/settings/shifts', {
        monday: {
            day: currentShifts.value[0][0],
            dayNumber: currentShifts.value[0][1].dayNumber,
            uuid: currentShifts.value[0][1].uuid,
            start: currentShifts.value[0][1].start,
            end: currentShifts.value[0][1].end,
            break: currentShifts.value[0][1].break,
            breakDuration: currentShifts.value[0][1].breakDuration,
        },
        tuesday: {
            day: currentShifts.value[1][0],
            dayNumber: currentShifts.value[1][1].dayNumber,
            uuid: currentShifts.value[1][1].uuid,
            start: currentShifts.value[1][1].start,
            end: currentShifts.value[1][1].end,
            break: currentShifts.value[1][1].break,
            breakDuration: currentShifts.value[1][1].breakDuration,
        },
        wednesday: {
            day: currentShifts.value[2][0],
            dayNumber: currentShifts.value[2][1].dayNumber,
            uuid: currentShifts.value[2][1].uuid,
            start: currentShifts.value[2][1].start,
            end: currentShifts.value[2][1].end,
            break: currentShifts.value[2][1].break,
            breakDuration: currentShifts.value[2][1].breakDuration,
        },
        thursday: {
            day: currentShifts.value[3][0],
            dayNumber: currentShifts.value[3][1].dayNumber,
            uuid: currentShifts.value[3][1].uuid,
            start: currentShifts.value[3][1].start,
            end: currentShifts.value[3][1].end,
            break: currentShifts.value[3][1].break,
            breakDuration: currentShifts.value[3][1].breakDuration,
        },
        friday: {
            day: currentShifts.value[4][0],
            dayNumber: currentShifts.value[4][1].dayNumber,
            uuid: currentShifts.value[4][1].uuid,
            start: currentShifts.value[4][1].start,
            end: currentShifts.value[4][1].end,
            break: currentShifts.value[4][1].break,
            breakDuration: currentShifts.value[4][1].breakDuration,
        },
        saturday: {
            day: currentShifts.value[5][0],
            dayNumber: currentShifts.value[5][1].dayNumber,
            uuid: currentShifts.value[5][1].uuid,
            start: currentShifts.value[5][1].start,
            end: currentShifts.value[5][1].end,
            break: currentShifts.value[5][1].break,
            breakDuration: currentShifts.value[5][1].breakDuration,
        },
        sunday: {
            day: currentShifts.value[6][0],
            dayNumber: currentShifts.value[6][1].dayNumber,
            uuid: currentShifts.value[6][1].uuid,
            start: currentShifts.value[6][1].start,
            end: currentShifts.value[6][1].end,
            break: currentShifts.value[6][1].break,
            breakDuration: currentShifts.value[6][1].breakDuration,
        },
    }),
);

const submit = () => form.value.submit();
</script>

<template>
    <Head title="Availability" />

    <h1 class="sr-only">Availability</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            description="Select the shifts you are working"
            title="Availability"
            variant="small"
        />
    </div>
    <form class="space-y-6" @submit.prevent="submit">
        <div class="grid grid-cols-5 text-sm">
            <div class="col-start-2 px-4 text-left">Start</div>
            <div class="px-4 text-left">End</div>
            <div class="px-4 text-left">Break</div>
            <div class="text-center">Duration</div>
        </div>
        <div v-for="day in days" :key="day" class="grid grid-cols-5 text-sm">
            <div>{{ capitalize(day) }}</div>
            <label :for="day + 'Start'">
                <input
                    :id="day + 'Start'"
                    v-model="form[day].start"
                    :name="day + 'Start'"
                    class="col-start-2 px-4"
                    type="time"
                />
            </label>

            <input
                :id="day + 'End'"
                v-model="form[day].end"
                :name="day + 'End'"
                class="px-4"
                type="time"
            />
            <input
                :id="day + 'Break'"
                v-model="form[day].break"
                :name="day + 'Break'"
                class="px-4"
                type="time"
            />
            <input
                :id="day + 'BreakDuration'"
                v-model="form[day].breakDuration"
                :name="day + 'BreakDuration'"
                class="text-center"
                placeholder="minutes"
                type="text"
            />
        </div>
        <Button class="mt-2 cursor-pointer" type="submit">Update</Button>
    </form>
    <div class="toast">
        <div
            v-for="(message, field) in errors"
            v-bind:key="field"
            class="alert alert-error"
        >
            <span
                >{{ capitalize(split(field.toString(), '.')[0]) }}:
                {{ message }}</span
            >
        </div>
    </div>
</template>
