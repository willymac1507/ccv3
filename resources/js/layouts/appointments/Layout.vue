<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { toUrl } from '@/lib/utils';
import { search as searchOrganisation } from '@/routes/organisations';
import type { NavItem } from '@/types';
const sidebarNavItems: NavItem[] = [
    {
        title: 'Search',
        href: searchOrganisation(),
        gate: 'Client',
    },
    {
        title: 'My Appointments',
        href: '#',
        gate: 'Client',
    },
    {
        title: 'Manage Diary',
        href: '#',
        gate: 'Student',
    },
    {
        title: 'Admin',
        href: '#',
        gate: 'Admin',
    },
];

const { isCurrentOrParentUrl } = useCurrentUrl();

const rolesRaw: any = usePage().props.auth.user.roles;
const roles: Array<string> = rolesRaw.map((role: any) => role.name);
</script>

<template>
    <div class="px-4 py-6">
        <Heading
            description="Search and manage your appointments"
            title="Appointments"
        />

        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav
                    aria-label="Appointments"
                    class="flex flex-col space-y-1 space-x-0"
                >
                    <div
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        class="space-y-1"
                    >
                        <Button
                            v-if="roles.includes(<string>item.gate)"
                            :class="[
                                'w-full justify-start',
                                { 'bg-muted': isCurrentOrParentUrl(item.href) },
                            ]"
                            as-child
                            variant="ghost"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" class="h-4 w-4" />
                                {{ item.title }}
                            </Link>
                        </Button>
                    </div>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
