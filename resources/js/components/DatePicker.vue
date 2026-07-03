<script lang="ts" setup>
import { Icon } from '@iconify/vue';
import { CalendarDate } from '@internationalized/date';
import {
    DatePickerArrow,
    DatePickerCalendar,
    DatePickerCell,
    DatePickerCellTrigger,
    DatePickerContent,
    DatePickerField,
    DatePickerGrid,
    DatePickerGridBody,
    DatePickerGridHead,
    DatePickerGridRow,
    DatePickerHeadCell,
    DatePickerHeader,
    DatePickerHeading,
    DatePickerInput,
    DatePickerNext,
    DatePickerPrev,
    DatePickerRoot,
    DatePickerTrigger,
    Label,
} from 'reka-ui';
import type { Ref } from 'vue';
const selectedDate: Ref<any> = defineModel();
</script>

<template>
    <div class="flex flex-col gap-2">
        <Label class="text-sm text-stone-700 dark:text-white" for="appointment">
            Pick a date
        </Label>
        <DatePickerRoot
            id="appointment"
            v-model="selectedDate"
            :close-on-select="true"
            :is-date-unavailable="(date) => date.day === 15"
        >
            <DatePickerField
                v-slot="{ segments }"
                class="flex w-36 items-center justify-between rounded-lg border bg-white p-1 text-center text-sm text-green-800 shadow-sm select-none data-invalid:border-red-500"
                locale="en-GB"
            >
                <div class="flex items-center">
                    <template v-for="item in segments" :key="item.part">
                        <DatePickerInput
                            v-if="item.part === 'literal'"
                            :part="item.part"
                        >
                            {{ item.value }}
                        </DatePickerInput>
                        <DatePickerInput
                            v-else
                            :part="item.part"
                            class="rounded p-0.5 focus:shadow-[0_0_0_2px] focus:shadow-black focus:outline-none data-placeholder:text-green-800"
                        >
                            {{ item.value }}
                        </DatePickerInput>
                    </template>
                </div>

                <DatePickerTrigger
                    class="rounded p-1 focus:shadow-[0_0_0_2px] focus:shadow-black"
                >
                    <Icon class="text-base" icon="radix-icons:calendar" />
                </DatePickerTrigger>
            </DatePickerField>

            <DatePickerContent
                :side-offset="4"
                class="data-[state=open]:data-[side=top]:animate-slideDownAndFade data-[state=open]:data-[side=right]:animate-slideLeftAndFade data-[state=open]:data-[side=bottom]:animate-slideUpAndFade data-[state=open]:data-[side=left]:animate-slideRightAndFade rounded-xl border bg-white shadow-sm will-change-[transform,opacity]"
            >
                <DatePickerArrow class="fill-white stroke-gray-300" />
                <DatePickerCalendar v-slot="{ weekDays, grid }" class="p-4">
                    <DatePickerHeader class="flex items-center justify-between">
                        <DatePickerPrev
                            class="inline-flex h-7 w-7 cursor-pointer items-center justify-center rounded-md bg-transparent text-black hover:bg-stone-50 focus:shadow-[0_0_0_2px] focus:shadow-black active:scale-98 active:transition-all"
                        >
                            <Icon
                                class="h-4 w-4"
                                icon="radix-icons:chevron-left"
                            />
                        </DatePickerPrev>

                        <DatePickerHeading class="font-medium text-black" />
                        <DatePickerNext
                            class="inline-flex h-7 w-7 cursor-pointer items-center justify-center rounded-md bg-transparent text-black hover:bg-stone-50 focus:shadow-[0_0_0_2px] focus:shadow-black active:scale-98 active:transition-all"
                        >
                            <Icon
                                class="h-4 w-4"
                                icon="radix-icons:chevron-right"
                            />
                        </DatePickerNext>
                    </DatePickerHeader>
                    <div
                        class="flex flex-col space-y-4 pt-4 sm:flex-row sm:space-y-0 sm:space-x-4"
                    >
                        <DatePickerGrid
                            v-for="month in grid"
                            :key="month.value.toString()"
                            class="w-full border-collapse space-y-1 select-none"
                        >
                            <DatePickerGridHead>
                                <DatePickerGridRow
                                    class="mb-1 flex w-full justify-between"
                                >
                                    <DatePickerHeadCell
                                        v-for="day in weekDays"
                                        :key="day"
                                        class="w-8 rounded-md text-xs text-green-800"
                                    >
                                        {{ day }}
                                    </DatePickerHeadCell>
                                </DatePickerGridRow>
                            </DatePickerGridHead>
                            <DatePickerGridBody>
                                <DatePickerGridRow
                                    v-for="(weekDates, index) in month.rows"
                                    :key="`weekDate-${index}`"
                                    class="flex w-full"
                                >
                                    <DatePickerCell
                                        v-for="weekDate in weekDates"
                                        :key="weekDate.toString()"
                                        :date="weekDate"
                                    >
                                        <DatePickerCellTrigger
                                            :day="weekDate"
                                            :month="month.value"
                                            class="data-today:before:bg-green9 relative flex h-8 w-8 items-center justify-center rounded-[9px] border border-transparent bg-transparent text-sm font-normal whitespace-nowrap text-black outline-none before:absolute before:top-1.25 before:hidden before:h-1 before:w-1 before:rounded-full before:bg-white hover:border-black focus:shadow-[0_0_0_2px] focus:shadow-black data-[outside-view]:text-black/30 data-[selected]:bg-black data-[selected]:font-medium data-[selected]:text-white data-[selected]:before:bg-white data-[today]:before:block data-[unavailable]:pointer-events-none data-[unavailable]:text-black/30 data-[unavailable]:line-through"
                                        />
                                    </DatePickerCell>
                                </DatePickerGridRow>
                            </DatePickerGridBody>
                        </DatePickerGrid>
                    </div>
                </DatePickerCalendar>
            </DatePickerContent>
        </DatePickerRoot>
    </div>
</template>
