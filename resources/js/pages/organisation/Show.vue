<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';

interface Props {
    organisation: Organisation;
}

const props = defineProps<Props>();

import { show } from '@/routes/admin/super/organisation';

interface Organisation {
    id: number;
    name: string;
    postcode: string;
    admin_name: string;
    email: string;
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Organisation',
                href: show(1),
            },
        ],
    },
});
</script>

<template>
    <div class="px-4 py-6">
        <Head title="Organisations.Show" />
        <h1 class="sr-only">Organisation</h1>
        <div class="flex flex-col space-y-6">
            <Heading
                :title="props.organisation.name"
                description="Organisation details"
                variant="small"
            />
        </div>
    </div>
</template>

<style scoped></style>
