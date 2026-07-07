<script lang="ts" setup>
import { Head, usePage } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import organisations from '@/routes/organisations';
import { index } from '@/routes/shifts';
interface Props {
    student: [
        {
            id: number;
            name: string;
            organisation: number;
        },
    ];
}

defineProps<Props>();

const page = usePage();

console.log(page);

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Salon search',
                href: organisations.search(),
            },
            {
                title: 'Available students',
                href: index(),
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
    <Head title="Availability" />

    <h1 class="sr-only">Student Calendar</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            description="Current availability for the selected student."
            title="Student Calendar"
            variant="small"
        />
    </div>
</template>
