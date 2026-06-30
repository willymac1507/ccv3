<script lang="ts" setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import type { ComputedRef } from 'vue';
import { ref } from 'vue';
import { computed } from 'vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { edit } from '@/routes/services';

interface Page {
    props: {
        services: Array<any>;
        auth: {
            services: Array<any>;
        };
    };
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Services offered',
                href: edit(),
            },
        ],
    },
});

const page: Page = usePage();
const allServices = page.props.services;
const userServices = page.props.auth.services;
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
            description="Select which services you offer"
            title="Services"
            variant="small"
        />

        <form
            class="space-y-6"
            @submit.prevent="form.patch('/settings/services')"
        >
            <div class="flex w-1/2 flex-col gap-2">
                <label
                    v-for="service in serviceList"
                    :key="service.id"
                    :for="'service' + service.id"
                    class="label"
                >
                    {{ service.name }}
                    <input
                        :id="'service' + service.id"
                        v-model="form.selectedServices"
                        :value="service.id"
                        class="checkbox ml-auto border border-gray-500 checkbox-sm checked:border-gray-300"
                        name="form.selectedServices[]"
                        type="checkbox"
                    />
                </label>
            </div>
            <Button class="mt-2 cursor-pointer">Update</Button>
        </form>
    </div>
</template>

<style scoped></style>
