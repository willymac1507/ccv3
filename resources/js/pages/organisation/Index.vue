<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { index, show } from '@/routes/admin/super/organisation';

interface Organisation {
    id: number;
    name: string;
    postcode: string;
    admin_name: string;
    email: string;
}
interface Props {
    name: string;
    organisations: Array<Organisation>;
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Organisations',
                href: index(),
            },
        ],
    },
});

defineProps<Props>();
</script>

<template>
    <div class="px-4 py-6">
        <Head title="Organisations.Index" />
        <h1 class="sr-only">Organisations</h1>
        <div class="flex flex-col space-y-6">
            <Heading
                description="List of all registered organisations"
                title="Organisations"
                variant="small"
            />
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Postcode</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        <tr
                            v-for="organisation in organisations"
                            v-bind:key="organisation.id"
                        >
                            <td>
                                {{ organisation.name }}
                            </td>
                            <td>
                                {{ organisation.admin_name }}
                                <br />
                                <span class="badge badge-ghost badge-sm">{{
                                    organisation.email
                                }}</span>
                            </td>
                            <td>{{ organisation.postcode }}</td>
                            <th>
                                <Link
                                    :href="show(organisation.id)"
                                    class="text-xs text-neutral-500 hover:text-neutral-100"
                                >
                                    details<span class="sr-only"
                                        >, {{ organisation.name }}</span
                                    >
                                </Link>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
