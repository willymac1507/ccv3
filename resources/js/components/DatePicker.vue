<script lang="ts" setup>
import {
    DateFormatter,
    getLocalTimeZone,
    today,
} from '@internationalized/date';
import { CalendarIcon } from '@lucide/vue';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { Calendar } from '@/components/ui/calendar';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';

const date = ref<Date>();
const defaultPlaceholder = today(getLocalTimeZone());
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                :class="
                    cn(
                        'w-70 justify-start text-left font-normal',
                        !date && 'text-muted-foreground',
                    )
                "
                variant="outline"
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                {{ date ? date.toDateString() : 'Pick a date' }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar
                v-model="date"
                :default-placeholder="defaultPlaceholder"
                :initial-focus="true"
                layout="month-and-year"
            />
        </PopoverContent>
    </Popover>
</template>
