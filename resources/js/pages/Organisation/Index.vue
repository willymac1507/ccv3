<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

interface Props {
    name: string;
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Organisations',
                href: 'admin/super/organisations',
            },
        ],
    },
});

defineProps<Props>();
</script>

<template>
    <Head title="Index" />
    <div
        class="flex flex-1 overflow-hidden flex-col gap-4 rounded-xl p-4"
    >
        <PlaceholderPattern />

    </div>
</template>
