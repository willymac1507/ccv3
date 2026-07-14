<script lang="ts" setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
import CollapsibleNavItem from '@/components/CollapsibleNavItem.vue';
import { Collapsible } from '@/components/ui/collapsible';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    // useSidebar,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();

// const { isMobile, state } = useSidebar();
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
            </Collapsible>
        </SidebarMenu>
    </SidebarGroup>
</template>
