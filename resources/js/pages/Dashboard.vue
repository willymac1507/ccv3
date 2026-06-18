<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { ComputedRef } from 'vue';
import { computed, provide } from 'vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';
import DashMainSection from '../components/Dashboard/DashMainSection.vue';

interface Props {
    logo: string;
    appointmentsAsStudent: Array<any>;
    date: string;
}

const props = defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

const appointments: ComputedRef<any[] | undefined> = computed(() => props.appointmentsAsStudent);
console.log(props.appointmentsAsStudent);
provide('appointments', appointments);
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
        </div>
        <div
            class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 p-6 md:min-h-min dark:border-sidebar-border"
        >
            <DashMainSection :date='date' />
        </div>
    </div>
</template>
