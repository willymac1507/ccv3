<script lang="ts" setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
import { ChevronsUpDown } from '@lucide/vue';
import AppointmentMenuContent from '@/components/AppointmentMenuContent.vue';
import CollapsibleNavItem from '@/components/CollapsibleNavItem.vue';
import { Collapsible } from '@/components/ui/collapsible';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();

const { isMobile, state } = useSidebar();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <Collapsible
                v-for="item in items"
                :key="item.title"
                :default-open="item.isActive"
                as-child
                class="group/collapsible"
            >
                <SidebarMenuItem>
                    <SidebarMenuButton
                        v-if="!item.items"
                        :is-active="isCurrentUrl(item.href)"
                        :tooltip="item.title"
                        as-child
                    >
                        <Link :href="item.href">
                            <FontAwesomeIcon
                                :icon="item.icon ? item.icon : 'home'"
                            />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                    <CollapsibleNavItem v-else :item="item" />
                </SidebarMenuItem>
                <!--                <SidebarMenuItem>-->
                <!--                    <DropdownMenu>-->
                <!--                        <DropdownMenuTrigger as-child>-->
                <!--                            <SidebarMenuButton-->
                <!--                                class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"-->
                <!--                                data-test="sidebar-menu-button"-->
                <!--                                size="lg"-->
                <!--                            >-->
                <!--                                <FontAwesomeIcon-->
                <!--                                    icon="fa-solid fa-calendar-days"-->
                <!--                                />-->
                <!--                                <span>Appointments</span>-->
                <!--                                <ChevronsUpDown class="ml-auto size-4" />-->
                <!--                            </SidebarMenuButton>-->
                <!--                        </DropdownMenuTrigger>-->
                <!--                        <DropdownMenuContent-->
                <!--                            :side="-->
                <!--                                isMobile-->
                <!--                                    ? 'bottom'-->
                <!--                                    : state === 'collapsed'-->
                <!--                                      ? 'left'-->
                <!--                                      : 'bottom'-->
                <!--                            "-->
                <!--                            :side-offset="4"-->
                <!--                            align="end"-->
                <!--                            class="w-(&#45;&#45;reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"-->
                <!--                        >-->
                <!--                            <AppointmentMenuContent />-->
                <!--                        </DropdownMenuContent>-->
                <!--                    </DropdownMenu>-->
                <!--                </SidebarMenuItem>-->
            </Collapsible>
        </SidebarMenu>
    </SidebarGroup>
</template>
