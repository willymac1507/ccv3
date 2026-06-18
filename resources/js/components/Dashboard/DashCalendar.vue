<script setup lang="ts">
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';
import { router } from '@inertiajs/vue3';
import type { EachDayOfIntervalOptions } from 'date-fns';
import {
    addMonths,
    eachDayOfInterval,
    format,
    isMonday,
    isSameDay,
    isSameMonth,
    isSunday,
    isToday,
    lastDayOfMonth,
    nextSunday,
    previousMonday,
    startOfMonth,
    subMonths,
} from 'date-fns';
import type { ComputedRef, Ref } from 'vue';
import { ref } from 'vue';
import { computed } from 'vue';

const parentDate = defineModel<Date>();

const selectedDate: Ref = ref(parentDate.value || new Date());

function formatRaw(item: any) {
    return {
        date: format(item, 'yyyy-MM-dd'),
        isCurrentMonth: isSameMonth(item, selectedDate.value) || false,
        isToday: isToday(item) || false,
        isSelected: isSameDay(item, selectedDate.value) || false,
    };
}

const firstDay: ComputedRef<Date> = computed(() => {
    if (!isMonday(startOfMonth(selectedDate.value))) {
        return previousMonday(startOfMonth(selectedDate.value));
    } else {
        return startOfMonth(selectedDate.value);
    }
});

const lastDay: ComputedRef<Date> = computed(() => {
    if (!isSunday(lastDayOfMonth(selectedDate.value))) {
        return nextSunday(lastDayOfMonth(selectedDate.value));
    } else {
        return lastDayOfMonth(selectedDate.value);
    }
});

const rawDaysThisMonth: ComputedRef<
    Array<
        undefined extends EachDayOfIntervalOptions<infer DateType>
            ? DateType
            : Date extends Date
              ? Date
              : Date extends Date
                ? Date
                : Date
    >
> = computed(() => {
    return eachDayOfInterval({
        start: firstDay.value,
        end: lastDay.value,
    });
});

const days: ComputedRef<
    {
        date: string;
        isCurrentMonth: boolean;
        isToday: boolean;
        isSelected: boolean;
    }[]
> = computed(() => {
    return rawDaysThisMonth.value.map(formatRaw);
});

function previousMonth() {
    selectedDate.value = subMonths(startOfMonth(selectedDate.value), 1);
}

function nextMonth() {
    selectedDate.value = addMonths(startOfMonth(selectedDate.value), 1);
}

function changeSelectedDate(date: Date) {
    selectedDate.value = date;
    parentDate.value = date;
}

function dayNumber(date: string) {
    return format(date, 'd');
}

function goToToday() {
    // selectedDate.value = new Date();
    // parentDate.value = selectedDate.value;
    router.get('/dashboard');
}
</script>

<template>
    <div
        class="mt-10 text-center lg:col-start-8 lg:col-end-13 lg:row-start-1 lg:mt-9 xl:col-start-9"
    >
        <div class="flex items-center text-gray-900 dark:text-white">
            <button
                @click="previousMonth()"
                type="button"
                class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-white"
            >
                <span class="sr-only">Previous month</span>
                <ChevronLeftIcon class="size-5" aria-hidden="true" />
            </button>
            <div class="flex-auto text-sm font-semibold">
                {{ format(selectedDate, 'MMMM') }}
            </div>
            <button
                @click="nextMonth()"
                type="button"
                class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-white"
            >
                <span class="sr-only">Next month</span>
                <ChevronRightIcon class="size-5" aria-hidden="true" />
            </button>
        </div>
        <div class="flex w-full items-center mt-4"><button class="btn btn-primary mx-auto" @click="goToToday">Today</button></div>
        <div
            class="mt-6 grid grid-cols-7 text-xs/6 text-gray-500 dark:text-gray-400"
        >
            <div>M</div>
            <div>T</div>
            <div>W</div>
            <div>T</div>
            <div>F</div>
            <div>S</div>
            <div>S</div>
        </div>
        <div
            class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow-sm ring-1 ring-gray-200 dark:bg-white/15 dark:shadow-none dark:ring-white/15"
        >
            <button
                v-for="day in days"
                @click="changeSelectedDate(new Date(day.date))"
                @update:model-value="selectedDate = new Date(day.date)"
                :key="day.date"
                type="button"
                :data-is-current-month="day.isCurrentMonth ? '' : undefined"
                :data-is-selected="day.isSelected ? '' : undefined"
                :data-is-today="day.isToday ? '' : undefined"
                class="py-1.5 not-data-is-current-month:bg-gray-50 not-data-is-selected:not-data-is-current-month:not-data-is-today:text-gray-400 first:rounded-tl-lg last:rounded-br-lg hover:bg-gray-100 focus:z-10 data-is-current-month:bg-white not-data-is-selected:data-is-current-month:not-data-is-today:text-gray-900 data-is-current-month:hover:bg-gray-100 data-is-selected:font-semibold data-is-selected:text-white data-is-today:font-semibold data-is-today:not-data-is-selected:text-indigo-600 nth-36:rounded-bl-lg nth-7:rounded-tr-lg dark:not-data-is-current-month:bg-gray-900/75 dark:not-data-is-selected:not-data-is-current-month:not-data-is-today:text-gray-500 dark:hover:bg-gray-900/25 dark:data-is-current-month:bg-gray-900/90 dark:not-data-is-selected:data-is-current-month:not-data-is-today:text-white dark:data-is-current-month:hover:bg-gray-900/50 dark:data-is-selected:text-gray-900 dark:data-is-today:not-data-is-selected:text-indigo-400"
            >
                <time
                    :datetime="day.date"
                    class="mx-auto flex size-7 items-center justify-center rounded-full in-data-is-selected:not-in-data-is-today:bg-gray-900 in-data-is-selected:in-data-is-today:bg-indigo-600 dark:in-data-is-selected:not-in-data-is-today:bg-white dark:in-data-is-selected:in-data-is-today:bg-indigo-500"
                    >{{ dayNumber(day.date) }}</time
                >
            </button>
        </div>
    </div>
</template>
