<script lang="ts" setup>
import { Head, usePage } from '@inertiajs/vue3';
import { format, getHours, parse, roundToNearestHours } from 'date-fns';
import type { ComputedRef } from 'vue';
import { computed, reactive } from 'vue';
import Heading from '@/components/Heading.vue';
import { index } from '@/routes/appointments';
import organisations from '@/routes/organisations';
import type { Props, PageProps } from '@/types/appointments';

const page: PageProps = usePage();

const selectedDate: Date = page.props.date;
const { startTime, endTime, breakTime, duration } = reactive(page.props.shift);

// TODO - make this less hacky

const calendarStart = getHours(parseAndRound(startTime, 'floor'));
const calendarEnd = getHours(parseAndRound(endTime, 'ceil'));
const shiftStart = rowForTime(startTime);
const shiftEnd = rowForTime(endTime);
const showEndOffset =
    parseAndRound(endTime, 'ceil') === parse(endTime, 'HH:mm:ss', new Date());

console.log(showEndOffset);

const interval = 15; // minutes
const slots: ComputedRef = computed(() => {
    const result: Array<any> = [];

    for (
        let mins = calendarStart * 60;
        mins < calendarEnd * 60;
        mins += interval
    ) {
        result.push(
            mins % 60 === 0 ? `${String(mins / 60).padStart(2, '0')}:00` : '',
        );
    }

    return result;
});

const startOffsetStyle = computed(() => ({
    gridRow: `1 / span ${shiftStart - 1}`,
    gridColumn: 1,
}));

const endOffsetStyle = computed(() => ({
    gridRow: `${shiftEnd} / span ${slots.value.length - shiftEnd + 2}`,
    gridColumn: 1,
}));

function parseAndRound(time: string, roundingMethod: 'floor' | 'ceil') {
    return roundToNearestHours(parse(time, 'HH:mm:ss', new Date()), {
        roundingMethod,
    });
}
function rowForTime(time: string) {
    const [hours, minutes] = time.split(':').map(Number);

    return ((hours - calendarStart) * 60 + minutes) / interval + 2;
}

defineProps<Props>();

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
                                            class="-mt-2.5 -ml-14 w-14 pr-2 text-right text-xs/5 text-gray-400 dark:text-gray-500"
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
                                    <!-- Start of day -->
                                    <li
                                        :style="startOffsetStyle"
                                        class="relative mt-px flex dark:before:pointer-events-none dark:before:absolute dark:before:inset-1 dark:before:z-0 dark:before:rounded-lg dark:before:bg-gray-900"
                                    >
                                        <div
                                            class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 p-2 text-xs/5 hover:bg-blue-100 dark:bg-gray-600/15 dark:hover:bg-gray-600/20"
                                        />
                                    </li>
                                    <!-- End of day -->
                                    <li
                                        :style="endOffsetStyle"
                                        class="relative mt-px flex dark:before:pointer-events-none dark:before:absolute dark:before:inset-1 dark:before:z-0 dark:before:rounded-lg dark:before:bg-gray-900"
                                    >
                                        <div
                                            class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 p-2 text-xs/5 hover:bg-blue-100 dark:bg-gray-600/15 dark:hover:bg-gray-600/20"
                                        />
                                    </li>
                                    <!-- Appointments -->
                                    <li
                                        :style="`grid-row: ${rowForTime('10:00')} / span 4`"
                                        class="relative mt-px flex dark:before:pointer-events-none dark:before:absolute dark:before:inset-1 dark:before:z-0 dark:before:rounded-lg dark:before:bg-gray-900"
                                    >
                                        <a
                                            class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 p-2 text-xs/5 hover:bg-blue-100 dark:bg-blue-600/15 dark:hover:bg-blue-600/20"
                                            href="#"
                                        >
                                            <p
                                                class="order-1 font-semibold text-blue-700 dark:text-blue-300"
                                            >
                                                Breakfast
                                            </p>
                                            <p
                                                class="text-blue-500 group-hover:text-blue-700 dark:text-blue-400 dark:group-hover:text-blue-300"
                                            >
                                                <time
                                                    datetime="2022-01-22T06:00"
                                                    >10:00 AM</time
                                                >
                                            </p>
                                        </a>
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
