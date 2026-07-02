<script setup lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import {
    CalendarIcon,
    EllipsisHorizontalIcon,
    MapPinIcon,
} from '@heroicons/vue/20/solid';
import { router } from '@inertiajs/vue3';
import { format } from 'date-fns';
import type { ModelRef } from 'vue';
import { watch } from 'vue';

interface Props {
    meetings: Array<any> | undefined;
}

const props = defineProps<Props>();

const parentDate: ModelRef<any> = defineModel();

watch(parentDate, (value) =>
    router.get(
        '/dashboard',
        { date: format(value, 'yyyy-MM-dd') },
        {
            preserveState: true,
            preserveScroll: true,
        },
    ),
);
</script>

<template>
    <ol
        class="mt-4 divide-y divide-gray-100 text-sm/6 lg:col-span-7 xl:col-span-8 dark:divide-white/10"
    >
        <li
            v-for="meeting in props.meetings"
            :key="meeting.id"
            class="relative flex gap-x-6 py-6 xl:static"
        >
            <div class="flex-auto">
                <h3
                    class="pr-10 font-semibold text-gray-900 xl:pr-0 dark:text-white"
                >
                    {{ meeting.client.name }}
                </h3>
                <dl
                    class="mt-2 flex flex-col text-gray-500 xl:flex-row dark:text-gray-400"
                >
                    <div class="flex items-start gap-x-3">
                        <dt class="mt-0.5">
                            <span class="sr-only">Date</span>
                            <CalendarIcon
                                class="size-5 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                        </dt>
                        <dd>
                            <time :datetime="meeting.datetime"
                                >{{ format(meeting.date, 'EEE do MMM yyyy') }}
                                at
                                {{ meeting.time }}
                            </time>
                        </dd>
                    </div>
                    <div
                        class="mt-2 flex items-start gap-x-3 xl:mt-0 xl:ml-3.5 xl:border-l xl:border-gray-400/50 xl:pl-3.5 dark:xl:border-gray-500/50"
                    >
                        <dt class="mt-0.5">
                            <span class="sr-only">Location</span>
                            <MapPinIcon
                                class="size-5 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                        </dt>
                        <dd>{{ meeting.location }}</dd>
                    </div>
                </dl>
            </div>
            <Menu
                as="div"
                class="absolute top-6 right-0 xl:relative xl:top-auto xl:right-auto xl:self-center"
            >
                <MenuButton
                    class="relative flex items-center rounded-full text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-white"
                >
                    <span class="absolute -inset-2"></span>
                    <span class="sr-only">Open options</span>
                    <EllipsisHorizontalIcon class="size-5" aria-hidden="true" />
                </MenuButton>

                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <MenuItems
                        class="absolute right-0 z-10 mt-2 w-36 origin-top-right rounded-md bg-white shadow-lg outline-1 outline-black/5 dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10"
                    >
                        <div class="py-1">
                            <MenuItem v-slot="{ active }">
                                <a
                                    href="#"
                                    :class="[
                                        active
                                            ? 'bg-gray-100 text-gray-900 outline-hidden dark:bg-white/5 dark:text-white'
                                            : 'text-gray-700 dark:text-gray-300',
                                        'block px-4 py-2 text-sm',
                                    ]"
                                    >Open</a
                                >
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <a
                                    href="#"
                                    :class="[
                                        active
                                            ? 'bg-gray-100 text-gray-900 outline-hidden dark:bg-white/5 dark:text-white'
                                            : 'text-gray-700 dark:text-gray-300',
                                        'block px-4 py-2 text-sm',
                                    ]"
                                    >Cancel</a
                                >
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </li>
    </ol>
</template>
