<script lang="ts" setup>
import { Head, usePage } from '@inertiajs/vue3';
import { format, getHours, parse, roundToNearestHours } from 'date-fns';
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
const { startTime, endTime, breakTime, duration } = reactive(page.props.shift);

const calendarStart = minutesFromTime(startTime);
const calendarEnd = minutesFromTime(endTime);

const myDiary = page.props.auth.user.id === props.student.id;

const interval = 15; // minutes
const slots: ComputedRef = computed(() => {
    const result: Array<any> = [];

    for (let mins = calendarStart; mins < calendarEnd; mins += interval) {
        switch (mins % 60) {
            case 0:
                result.push(
                    `${String(Math.trunc(mins / 60)).padStart(2, '0')}:00`,
                );
                break;
            case 15:
                result.push(
                    `${String(Math.trunc(mins / 60)).padStart(2, '0')}:15`,
                );
                break;
            case 30:
                result.push(
                    `${String(Math.trunc(mins / 60)).padStart(2, '0')}:30`,
                );
                break;
            case 45:
                result.push(
                    `${String(Math.trunc(mins / 60)).padStart(2, '0')}:45`,
                );
                break;
            default:
                result.push('');
        }
    }

    return result;
});

function minutesFromTime(time: string) {
    const [hours, minutes] = time.split(':').map(Number);

    return hours * 60 + minutes;
}
function rowForTime(time: string) {
    const [hours, minutes] = time.split(':').map(Number);

    return (hours * 60 - calendarStart + minutes) / interval + 2;
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
                                            {{ slot }}
                                        </div>
                                    </div>
                                    <div></div>
                                </div>

                                <!-- Events -->
                                <ol
                                    :style="`grid-template-rows: 1.75rem repeat(${slots.length}, minmax(0, 1fr)) auto;`"
                                    class="col-start-1 col-end-2 row-start-1 grid grid-cols-1"
                                >
                                    <!-- Break -->
                                    <li
                                        v-if="breakTime"
                                        :style="`grid-row: ${rowForTime(breakTime)} / span ${duration / 15}`"
                                        class="relative mt-px flex dark:before:pointer-events-none dark:before:absolute dark:before:inset-1 dark:before:z-0 dark:before:rounded-lg dark:before:bg-gray-900"
                                    >
                                        <div
                                            class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 px-2 text-xs/5 hover:bg-blue-100 dark:bg-blue-600/15 dark:hover:bg-blue-600/20"
                                        >
                                            <p
                                                class="order-1 font-semibold text-blue-700 dark:text-blue-300"
                                            >
                                                Break
                                            </p>
                                            <p
                                                class="text-blue-500 group-hover:text-blue-700 dark:text-blue-400 dark:group-hover:text-blue-300"
                                            ></p>
                                        </div>
                                    </li>
                                    <li
                                        v-for="appointment in appointments"
                                        :key="appointment.id"
                                        :style="`grid-row: ${rowForTime(appointment.time)} / span ${appointment.duration}`"
                                        class="relative mt-px flex dark:before:pointer-events-none dark:before:absolute dark:before:inset-1 dark:before:z-0 dark:before:rounded-lg dark:before:bg-gray-900"
                                    >
                                        <div
                                            class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 px-2 py-1 text-xs/5 hover:bg-green-100 dark:bg-green-600/15 dark:hover:bg-green-600/20"
                                        >
                                            <p
                                                class="font-semibold text-green-700 dark:text-green-300"
                                            >
                                                {{ appointment.client.name }}
                                            </p>
                                            <p
                                                class="text-green-500 group-hover:text-green-700 dark:text-green-400 dark:group-hover:text-green-300"
                                            >
                                                {{ appointment.description }}
                                            </p>
                                        </div>
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
