<script lang="ts" setup>
import { Head, usePage } from '@inertiajs/vue3';
import { format } from 'date-fns';
import type { ComputedRef } from 'vue';
import { computed, reactive } from 'vue';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/appointments';
import organisations from '@/routes/organisations';
import type { Props, PageProps } from '@/types/appointments';

const props = defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Salon search',
                href: organisations.search(),
            },
            {
                title: 'Student calendar',
                href: index(),
            },
        ],
    },
});

const page: PageProps = usePage();
const selectedDate: Date = page.props.date;
const { startTime, endTime } = reactive(page.props.shift);

const calendarStart = minutesFromTime(startTime);
const calendarEnd = minutesFromTime(endTime);

const myDiary = page.props.auth.user.id === props.student.id;

const interval = 15; // minutes
const slots: ComputedRef = computed(() => {
    const result: Array<any> = [];

    for (let mins = calendarStart; mins < calendarEnd; mins += interval) {
        switch (mins % 60) {
            case 0:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:00`,
                    blocked: false,
                });
                break;
            case 15:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:15`,
                    blocked: false,
                });
                break;
            case 30:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:30`,
                    blocked: false,
                });
                break;
            case 45:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:45`,
                    blocked: false,
                });
                break;
            default:
                result.push('');
        }
    }

    return result;
});

const vBlock = {
    mounted(el: any, binding: any) {
        const start = binding.value.row - 2;
        const end = start + binding.value.span;

        for (let i = start; i < end; i++) {
            slots.value[i].blocked = true;
        }
    },
};

let freeSlotsCount = 0;

function appointmentStatusClass(appointment: any) {
    if (appointment.status === 'cancelled') {
        return 'bg-red-500/10 hover:bg-red-500/20 text-red-500';
    } else if (appointment.status === 'confirmed') {
        return 'bg-green-500/10 hover:bg-green-500/20 text-green-500';
    } else if (appointment.status === 'pending') {
        return 'bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-500';
    } else {
        return 'bg-blue-500/10 hover:bg-blue-500/20 text-blue-500';
    }
}

function minutesFromTime(time: string) {
    const [hours, minutes] = time.split(':').map(Number);

    return hours * 60 + minutes;
}
function rowForTime(time: string) {
    const [hours, minutes] = time.split(':').map(Number);

    return (hours * 60 - calendarStart + minutes) / interval + 2;
}

function clicked(event: any) {
    freeSlotsCount = 0;

    for (let i = event.target.value; i < slots.value.length; i++) {
        if (slots.value[i].blocked) {
            console.log('Free Slots', freeSlotsCount);

            break;
        } else if (i === slots.value.length - 1) {
            freeSlotsCount++;
            console.log('Free Slots', freeSlotsCount);

            break;
        }

        console.log(i, 'Free');
        freeSlotsCount++;
    }
}
</script>

<template>
    <div class="max-h-screen px-4 py-6">
        <Head title="Availability" />

        <h1 class="sr-only">Student Calendar</h1>

        <div class="mb-4 flex flex-col space-y-6">
            <Heading
                :description="student.name"
                title="Student Calendar"
                variant="small"
            />
        </div>

        <div class="h-3/4">
            <div class="flex h-full flex-col">
                <header
                    class="flex flex-none items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-white/10 dark:bg-gray-800/50 dark:max-md:border-white/15"
                >
                    <div>
                        <h1
                            class="text-base font-semibold text-gray-900 dark:text-white"
                        >
                            <time
                                :datetime="format(selectedDate, 'yyyy-MM-dd')"
                                class="sm:hidden"
                                >{{
                                    format(selectedDate, 'dd-MMM, yyyy')
                                }}</time
                            >
                            <time
                                :datetime="format(selectedDate, 'yyyy-MM-dd')"
                                class="hidden sm:inline"
                                >{{
                                    format(selectedDate, 'dd-MMM, yyyy')
                                }}</time
                            >
                        </h1>
                        <p
                            class="mt-1 text-sm text-gray-500 dark:text-gray-400"
                        >
                            {{ format(selectedDate, 'EEEE') }}
                        </p>
                    </div>
                </header>
                <div
                    class="isolate flex flex-auto overflow-hidden bg-white dark:bg-gray-900"
                >
                    <div class="flex flex-auto flex-col overflow-auto">
                        <div class="flex w-full flex-auto">
                            <div
                                class="w-14 flex-none bg-white ring-1 ring-gray-100 dark:bg-gray-900 dark:ring-white/5"
                            ></div>
                            <div class="grid flex-auto grid-cols-1 grid-rows-1">
                                <!-- Horizontal lines -->
                                <div
                                    :style="`grid-template-rows: repeat(${slots.length}, minmax(1.75rem, 1fr));`"
                                    class="col-start-1 col-end-2 row-start-1 grid divide-y divide-gray-100 dark:divide-white/5"
                                >
                                    <div class="row-end-1 h-7"></div>
                                    <div
                                        v-for="(slot, index) in slots"
                                        :key="index"
                                    >
                                        <div
                                            class="-mt-2.5 -ml-14 w-14 pr-2 text-right font-mono text-xs/5 text-gray-400 dark:text-gray-500"
                                        >
                                            {{ slot.label }}
                                        </div>
                                    </div>
                                    <div></div>
                                </div>

                                <!-- Booking Buttons -->

                                <!-- Events -->
                                <ol
                                    :style="`grid-template-rows: 1.75rem repeat(${slots.length}, minmax(0, 1fr)) auto;`"
                                    class="z-10 col-start-1 col-end-2 row-start-1 grid grid-cols-1"
                                >
                                    <li
                                        v-for="appointment in appointments"
                                        :key="appointment.id"
                                        v-block="{
                                            row: rowForTime(appointment.time),
                                            span: appointment.duration,
                                        }"
                                        :style="`grid-row: ${rowForTime(appointment.time)} / span ${appointment.duration}`"
                                        class="relative z-10 col-start-1 mt-px flex dark:before:pointer-events-none dark:before:absolute dark:before:inset-1 dark:before:z-0 dark:before:rounded-lg dark:before:bg-gray-900"
                                    >
                                        <component
                                            :is="
                                                !appointment.status
                                                    ? 'div'
                                                    : 'a'
                                            "
                                            :class="
                                                appointmentStatusClass(
                                                    appointment,
                                                )
                                            "
                                            :href="
                                                appointment.description ===
                                                'Break'
                                                    ? '#'
                                                    : '/appointments/' +
                                                      appointment.id +
                                                      '/show'
                                            "
                                            class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg px-2 text-xs/5"
                                        >
                                            <p
                                                v-if="myDiary"
                                                class="font-semibold"
                                            >
                                                {{ appointment.client.name }}
                                            </p>
                                            <p>
                                                {{ appointment.description }}
                                            </p>
                                        </component>
                                    </li>
                                    <li
                                        v-for="(slot, index) in slots"
                                        v-show="!slot.blocked"
                                        :key="slot.blocked"
                                        :style="`grid-row: ${rowForTime(slot.label)} / span 1;`"
                                        class="z-1 col-start-1"
                                    >
                                        <button
                                            :value="index"
                                            class="h-full w-full cursor-pointer"
                                            @click="clicked($event)"
                                        ></button>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
