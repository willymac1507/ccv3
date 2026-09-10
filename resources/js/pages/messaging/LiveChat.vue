<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import {
    computed,
    nextTick,
    onMounted,
    ref,
    shallowRef,
    useTemplateRef,
} from 'vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

interface ChatMessage {
    id: number;
    author: 'me' | 'them';
    body: string;
    sentAt: Date;
}

interface Conversation {
    id: number;
    participantName: string;
    status: 'online' | 'offline';
    unreadCount: number;
    messages: ChatMessage[];
}

defineOptions({
    inheritAttrs: false,
    layout: {
        breadcrumbs: [
            {
                title: 'Messages',
                href: '#',
            },
        ],
    },
});

const conversations = shallowRef<Conversation[]>([
    {
        id: 1,
        participantName: 'Alex Kim',
        status: 'online',
        unreadCount: 2,
        messages: [
            {
                id: 1,
                author: 'them',
                body: 'Hey! Are we still on for the 3pm slot tomorrow?',
                sentAt: new Date(Date.now() - 1000 * 60 * 42),
            },
            {
                id: 2,
                author: 'me',
                body: 'Yes — I just confirmed the room with reception.',
                sentAt: new Date(Date.now() - 1000 * 60 * 36),
            },
            {
                id: 3,
                author: 'them',
                body: 'Perfect. See you then.',
                sentAt: new Date(Date.now() - 1000 * 60 * 28),
            },
        ],
    },
    {
        id: 2,
        participantName: 'Maya Patel',
        status: 'offline',
        unreadCount: 0,
        messages: [
            {
                id: 4,
                author: 'them',
                body: 'Thanks for sending that over.',
                sentAt: new Date(Date.now() - 1000 * 60 * 60 * 2),
            },
            {
                id: 5,
                author: 'me',
                body: 'No problem — let me know if you need anything else.',
                sentAt: new Date(
                    Date.now() - 1000 * 60 * 60 * 2 + 1000 * 60 * 4,
                ),
            },
        ],
    },
    {
        id: 3,
        participantName: 'Jordan Smith',
        status: 'online',
        unreadCount: 1,
        messages: [
            {
                id: 6,
                author: 'them',
                body: 'Could we move the appointment to Friday?',
                sentAt: new Date(Date.now() - 1000 * 60 * 60 * 5),
            },
        ],
    },
    {
        id: 4,
        participantName: 'Priya Sharma',
        status: 'offline',
        unreadCount: 0,
        messages: [
            {
                id: 7,
                author: 'me',
                body: 'I have updated the details for your booking.',
                sentAt: new Date(Date.now() - 1000 * 60 * 60 * 24),
            },
            {
                id: 8,
                author: 'them',
                body: 'Brilliant, thank you!',
                sentAt: new Date(Date.now() - 1000 * 60 * 60 * 23),
            },
        ],
    },
]);

const selectedConversationId = ref(conversations.value[0]?.id ?? null);
const draft = ref('');
const search = ref('');
const scrollContainer = useTemplateRef<HTMLDivElement>('scrollContainer');

const selectedConversation = computed(
    () =>
        conversations.value.find(
            (conversation) => conversation.id === selectedConversationId.value,
        ) ?? null,
);

const filteredConversations = computed(() => {
    const term = search.value.trim().toLowerCase();

    if (!term) {
        return conversations.value;
    }

    return conversations.value.filter((conversation) =>
        conversation.participantName.toLowerCase().includes(term),
    );
});

const lastMessage = (conversation: Conversation) =>
    conversation.messages[conversation.messages.length - 1] ?? null;

const formatTime = (date: Date) =>
    date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

const formatConversationTime = (date: Date) => {
    const now = new Date();
    const isToday = date.toDateString() === now.toDateString();

    if (isToday) {
        return formatTime(date);
    }

    return date.toLocaleDateString([], {
        day: '2-digit',
        month: 'short',
    });
};

const initials = (name: string) =>
    name
        .split(' ')
        .map((part) => part[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();

const scrollToBottom = () => {
    const el = scrollContainer.value;

    if (!el) {
        return;
    }

    el.scrollTop = el.scrollHeight;
};

const selectConversation = async (conversationId: number) => {
    selectedConversationId.value = conversationId;

    conversations.value = conversations.value.map((conversation) =>
        conversation.id === conversationId
            ? {
                  ...conversation,
                  unreadCount: 0,
              }
            : conversation,
    );

    await nextTick();
    scrollToBottom();
};

const send = async () => {
    const body = draft.value.trim();

    if (!body || !selectedConversation.value) {
        return;
    }

    const newMessage: ChatMessage = {
        id: Date.now(),
        author: 'me',
        body,
        sentAt: new Date(),
    };

    conversations.value = conversations.value.map((conversation) =>
        conversation.id === selectedConversation.value?.id
            ? {
                  ...conversation,
                  messages: [...conversation.messages, newMessage],
              }
            : conversation,
    );

    draft.value = '';

    await nextTick();
    scrollToBottom();
};

onMounted(scrollToBottom);
</script>

<template>
    <Head title="Messages" />

    <div class="flex h-full flex-1 flex-col p-4">
        <div
            class="grid h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 bg-background lg:grid-cols-[360px_1fr] dark:border-sidebar-border"
        >
            <aside
                class="flex min-h-0 flex-col border-b border-sidebar-border/70 lg:border-r lg:border-b-0 dark:border-sidebar-border"
            >
                <div
                    class="border-b border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <div class="mb-4">
                        <h1 class="text-lg font-semibold tracking-tight">
                            Messages
                        </h1>
                        <p class="text-sm text-muted-foreground">
                            View your recent conversations
                        </p>
                    </div>

                    <Input
                        v-model="search"
                        autocomplete="off"
                        placeholder="Search conversations..."
                    />
                </div>

                <div class="min-h-0 flex-1 overflow-y-auto">
                    <button
                        v-for="conversation in filteredConversations"
                        :key="conversation.id"
                        :class="
                            selectedConversationId === conversation.id
                                ? 'bg-muted'
                                : 'hover:bg-muted/60'
                        "
                        class="flex w-full items-center gap-3 border-b border-sidebar-border/50 px-4 py-3 text-left transition-colors dark:border-sidebar-border/70"
                        type="button"
                        @click="selectConversation(conversation.id)"
                    >
                        <div class="relative">
                            <Avatar>
                                <AvatarFallback>
                                    {{ initials(conversation.participantName) }}
                                </AvatarFallback>
                            </Avatar>

                            <span
                                :class="
                                    conversation.status === 'online'
                                        ? 'bg-emerald-500'
                                        : 'bg-muted-foreground'
                                "
                                class="absolute right-0 bottom-0 size-2.5 rounded-full ring-2 ring-background"
                            />
                        </div>

                        <div class="min-w-0 flex-1">
                            <div
                                class="flex items-center justify-between gap-3"
                            >
                                <p class="truncate text-sm font-medium">
                                    {{ conversation.participantName }}
                                </p>

                                <span
                                    v-if="lastMessage(conversation)"
                                    class="shrink-0 text-xs text-muted-foreground"
                                >
                                    {{
                                        formatConversationTime(
                                            lastMessage(conversation)!.sentAt,
                                        )
                                    }}
                                </span>
                            </div>

                            <div
                                class="mt-1 flex items-center justify-between gap-3"
                            >
                                <p
                                    class="truncate text-sm text-muted-foreground"
                                >
                                    {{
                                        lastMessage(conversation)?.body ??
                                        'No messages yet'
                                    }}
                                </p>

                                <span
                                    v-if="conversation.unreadCount > 0"
                                    class="flex size-5 shrink-0 items-center justify-center rounded-full bg-primary text-[11px] font-medium text-primary-foreground"
                                >
                                    {{ conversation.unreadCount }}
                                </span>
                            </div>
                        </div>
                    </button>

                    <div
                        v-if="filteredConversations.length === 0"
                        class="p-6 text-center text-sm text-muted-foreground"
                    >
                        No conversations found.
                    </div>
                </div>
            </aside>

            <section v-if="selectedConversation" class="flex min-h-0 flex-col">
                <header
                    class="flex items-center gap-3 border-b border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                >
                    <Avatar>
                        <AvatarFallback>
                            {{ initials(selectedConversation.participantName) }}
                        </AvatarFallback>
                    </Avatar>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium">
                            {{ selectedConversation.participantName }}
                        </p>

                        <p
                            class="flex items-center gap-1.5 text-xs text-muted-foreground"
                        >
                            <span
                                :class="
                                    selectedConversation.status === 'online'
                                        ? 'bg-emerald-500'
                                        : 'bg-muted-foreground'
                                "
                                class="size-2 rounded-full"
                            />
                            {{
                                selectedConversation.status === 'online'
                                    ? 'Online'
                                    : 'Offline'
                            }}
                        </p>
                    </div>
                </header>

                <div
                    ref="scrollContainer"
                    class="min-h-0 flex-1 space-y-4 overflow-y-auto px-4 py-6"
                >
                    <div
                        v-for="message in selectedConversation.messages"
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
                                {{
                                    initials(
                                        selectedConversation.participantName,
                                    )
                                }}
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

                            <span
                                class="px-1 text-[11px] text-muted-foreground"
                            >
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
                        placeholder="Write a message..."
                    />

                    <Button :disabled="!draft.trim()" type="submit">
                        Send
                    </Button>
                </form>
            </section>

            <section
                v-else
                class="flex min-h-[400px] items-center justify-center p-8 text-center text-sm text-muted-foreground"
            >
                Select a conversation to start messaging.
            </section>
        </div>
    </div>
</template>
