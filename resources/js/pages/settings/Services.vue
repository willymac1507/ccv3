<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import type { ComputedRef } from 'vue';
import { ref } from 'vue';
import { computed } from 'vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';

const page = usePage();
// const user: ComputedRef = computed(() => page.props.auth.user);
const { services: allServices } = page.props;
const { services: userServices } = page.props.auth.user;
const servicesOffered: ComputedRef = computed(() => userServices);
const servicesOfferedIds: ComputedRef = computed(() =>
    servicesOffered.value.map((service: { id: any }) => service.id),
);
const serviceList: ComputedRef = computed(() => allServices);

const checked = ref(servicesOfferedIds.value);
const form = ref(
    useForm({
        selectedServices: checked.value,
    }),
);
</script>

<template>
    <Head title="Services" />

    <h1 class="sr-only">Services</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            variant="small"
            title="Services"
            description="Select which services you offer"
        />

        <form
            @submit.prevent="form.post('/settings/services')"
            class="space-y-6"
        >
            <div class="flex w-1/2 flex-col gap-2">
                <label
                    class="label"
                    :for="'service' + service.id"
                    v-for="service in serviceList"
                    :key="service.id"
                >
                    {{ service.name }}
                    <input
                        type="checkbox"
                        :value="service.id"
                        v-model="form.selectedServices"
                        class="checkbox ml-auto border border-gray-400 checkbox-sm"
                        :id="'service' + service.id"
                        name="form.selectedServices[]"
                    />
                </label>
            </div>
            <Button class="mt-2">Update</Button>
        </form>
    </div>
</template>

<style scoped></style>
