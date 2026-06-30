<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import { GoogleMap, AdvancedMarker } from 'vue3-google-map';
import Heading from '@/components/Heading.vue';
import { show, index } from '@/routes/admin/super/organisation';

interface Props {
    organisation: Organisation;
}

const props = defineProps<Props>();

interface Organisation {
    id: number;
    name: string;
    postcode: string;
    admin_name: string;
    email: string;
    lat: string;
    lng: string;
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Organisations',
                href: index(),
            },
            {
                title: 'Organisation',
                href: show(1),
            },
        ],
    },
});

const center = {
    lat: parseFloat(props.organisation.lat),
    lng: parseFloat(props.organisation.lng),
};
const markerOptions = {
    position: center,
    title: props.organisation.name.toUpperCase(),
};
const pinOptions = {
    background: 'lightblue',
    glyphColor: '#000000',
    glyphSrc: '/images/scissors-solid-full.svg',
};
const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
</script>

<template>
    <div class="px-4 py-6">
        <Head title="Organisations.Show" />
        <h1 class="sr-only">Organisation</h1>
        <div class="flex flex-col space-y-6">
            <Heading
                :title="props.organisation.name"
                description="Organisation details"
                variant="small"
            />
        </div>
        <div class="mt-6 grid w-full items-center">
            <GoogleMap
                :api-key="apiKey"
                :center="center"
                :zoom="15"
                map-id="DEMO_MAP_ID"
                style="width: 100%; height: 400px"
            >
                <AdvancedMarker
                    :options="markerOptions"
                    :pin-options="pinOptions"
                />
            </GoogleMap>
        </div>
    </div>
</template>

<style scoped></style>
