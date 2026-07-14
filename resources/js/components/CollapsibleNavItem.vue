<script lang="ts" setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from '@lucide/vue';
import {
    CollapsibleTrigger,
    CollapsibleContent,
} from '@/components/ui/collapsible';
import {
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';

const props = defineProps(['item']);

console.log(props.item.items);
</script>

<template>
    <CollapsibleTrigger as-child>
        <SidebarMenuButton :tooltip="item.title">
            <FontAwesomeIcon :icon="item.icon ? item.icon : 'home'" />
            <span>{{ item.title }}</span>
            <ChevronRight
                class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
            />
        </SidebarMenuButton>
    </CollapsibleTrigger>
    <CollapsibleContent>
        <SidebarMenuSub>
            <SidebarMenuSubItem
                v-for="subItem in item['items']"
                :key="subItem.title"
            >
                <SidebarMenuSubButton as-child>
                    <Link :href="subItem.href">
                        <span>{{ subItem.title }}</span>
                    </Link>
                </SidebarMenuSubButton>
            </SidebarMenuSubItem>
        </SidebarMenuSub>
    </CollapsibleContent>
</template>

<style scoped></style>
