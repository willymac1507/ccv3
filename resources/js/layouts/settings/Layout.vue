<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { toUrl } from '@/lib/utils';
import { edit as editAppearance } from '@/routes/appearance';
import { edit as editProfile } from '@/routes/profile';
import { edit as editSecurity } from '@/routes/security';
import { edit as editServices } from '@/routes/services';
import { edit as editSlots } from '@/routes/slots';
import type { NavItem } from '@/types';
const sidebarNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: editProfile(),
        gate: 'Client',
    },
    {
        title: 'Services',
        href: editServices(),
        gate: 'Student',
    },
    {
        title: 'Time Slots',
        href: editSlots(),
        gate: 'Student',
    },
    {
        title: 'Security',
        href: editSecurity(),
        gate: 'Client',
    },
    {
        title: 'Appearance',
        href: editAppearance(),
        gate: 'Client',
    },
];

const { isCurrentOrParentUrl } = useCurrentUrl();

const rolesRaw: any = usePage().props.auth.user.roles;
const roles: Array<string> = rolesRaw.map((role: any) => role.name);

</script>

<template>
    <div class="px-4 py-6">
        <Heading
            title="Settings"
            description="Manage your profile and account settings"
        />

        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav
                    class="flex flex-col space-y-1 space-x-0"
                    aria-label="Settings"
                >
                    <div
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        class="space-y-1"
                    >
                        <Button
                            v-if="roles.includes(<string>item.gate)"
                            variant="ghost"
                            :class="[
                                'w-full justify-start',
                                { 'bg-muted': isCurrentOrParentUrl(item.href) },
                            ]"
                            as-child
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
