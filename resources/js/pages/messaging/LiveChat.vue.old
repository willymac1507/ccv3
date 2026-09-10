<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import { nextTick, onMounted, ref, shallowRef, useTemplateRef } from 'vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

interface ChatMessage {
    id: number;
    author: 'me' | 'them';
    name: string;
    body: string;
    sentAt: Date;
}

defineOptions({
    inheritAttrs: false,
    layout: {
        breadcrumbs: [
            {
                title: 'Contacts',
                href: '#',
            },
            {
                title: 'Live Chat',
                href: '#',
            },
        ],
    },
});

const messages = shallowRef<ChatMessage[]>([
    {
        id: 1,
        author: 'them',
        name: 'Alex Kim',
        body: 'Hey! Are we still on for the 3pm slot tomorrow?',
        sentAt: new Date(Date.now() - 1000 * 60 * 12),
    },
    {
        id: 2,
        author: 'me',
        name: 'You',
        body: 'Yes — I just confirmed the room with reception.',
        sentAt: new Date(Date.now() - 1000 * 60 * 10),
    },
    {
        id: 3,
        author: 'them',
        name: 'Alex Kim',
        body: 'Perfect. See you then.',
        sentAt: new Date(Date.now() - 1000 * 60 * 8),
    },
]);

const draft = ref('');
const scrollContainer = useTemplateRef<HTMLDivElement>('scrollContainer');

const scrollToBottom = () => {
    const el = scrollContainer.value;

    if (!el) {
        return;
    }

    el.scrollTop = el.scrollHeight;
};

const formatTime = (date: Date) =>
    date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

const initials = (name: string) =>
    name
        .split(' ')
        .map((part) => part[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();

const send = async () => {
    const body = draft.value.trim();

    if (!body) {
        return;
    }

    messages.value = [
        ...messages.value,
        {
            id: Date.now(),
            author: 'me',
            name: 'You',
            body,
            sentAt: new Date(),
        },
    ];
    draft.value = '';
    await nextTick();
    scrollToBottom();
};

onMounted(scrollToBottom);
</script>

<template>
    <Head title="Live chat" />

    <div class="flex h-full flex-1 flex-col p-4">
        <div
            class="flex h-full flex-1 flex-col overflow-hidden rounded-xl border border-sidebar-border/70 bg-background dark:border-sidebar-border"
        >
            <header
                class="flex items-center gap-3 border-b border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
            >
                <Avatar>
                    <AvatarFallback>AK</AvatarFallback>
                </Avatar>
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium">Alex Kim</p>
                    <p
                        class="flex items-center gap-1.5 text-xs text-muted-foreground"
                    >
                        <span class="size-2 rounded-full bg-emerald-500" />
                        Online
                    </p>
                </div>
            </header>

            <div
                ref="scrollContainer"
                class="flex-1 space-y-4 overflow-y-auto px-4 py-6"
            >
                <div
                    v-for="message in messages"
                    :key="message.id"
                    :class="
                        message.author === 'me'
                            ? 'justify-end'
                            : 'justify-start'
                    "
                    class="flex items-end gap-2"
                >
                    <Avatar v-if="message.author === 'them'" class="size-8">
                        <AvatarFallback class="text-xs">
                            {{ initials(message.name) }}
                        </AvatarFallback>
                    </Avatar>

                    <div
                        :class="
                            message.author === 'me'
                                ? 'items-end'
                                : 'items-start'
                        "
                        class="flex max-w-[75%] flex-col gap-1"
                    >
                        <div
                            :class="
                                message.author === 'me'
                                    ? 'rounded-br-sm bg-primary text-primary-foreground'
                                    : 'rounded-bl-sm bg-muted text-foreground'
                            "
                            class="rounded-2xl px-4 py-2 text-sm shadow-sm"
                        >
                            {{ message.body }}
                        </div>
                        <span class="px-1 text-[11px] text-muted-foreground">
                            {{ formatTime(message.sentAt) }}
                        </span>
                    </div>

                    <Avatar v-if="message.author === 'me'" class="size-8">
                        <AvatarFallback class="text-xs">You</AvatarFallback>
                    </Avatar>
                </div>
            </div>

            <form
                class="flex items-center gap-2 border-t border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                @submit.prevent="send"
            >
                <Input
                    v-model="draft"
                    autocomplete="off"
                    class="flex-1"
                    placeholder="Write a message…"
                />
                <Button :disabled="!draft.trim()" type="submit">Send</Button>
            </form>
        </div>
    </div>
</template>
