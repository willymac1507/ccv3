<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Search, SquarePenIcon } from '@lucide/vue';
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import { search } from '@/routes/organisations';
import type { Roles } from '@/types/auth';

// @ts-expect-error - TS throws an error here as it cannot determine the type of the roles array
const roles: Array<Roles> = usePage().props.auth.user.roles;

const userRoles: Array<string> = roles.map((role: any) => role.name);
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            Appointments
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link :href="search()" class="block w-full cursor-pointer" prefetch>
                <Search class="mr-2 h-4 w-4" />
                Search
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem v-if="userRoles.includes('Student')" :as-child="true">
        <Link
            as="button"
            class="block w-full cursor-pointer"
            data-test="logout-button"
            href="#"
        >
            <SquarePenIcon class="mr-2 h-4 w-4" />
            Manage
        </Link>
    </DropdownMenuItem>
</template>
