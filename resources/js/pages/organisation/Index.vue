<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3';
import { GoogleMap, AdvancedMarker, MarkerCluster } from 'vue3-google-map';
import Heading from '@/components/Heading.vue';
import { index, show } from '@/routes/admin/super/organisation';

interface Organisation {
    id: number;
    name: string;
    postcode: string;
    admin_name: string;
    email: string;
    lat: string;
    lng: string;
}
interface Props {
    name: string;
    organisations: Array<Organisation>;
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Organisations',
                href: index(),
            },
        ],
    },
});

defineProps<Props>();

const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

function showOrg(id: number) {
    router.get(show(id));
}
</script>

<template>
    <div class="px-4 py-6">
        <Head title="Organisations.Index" />
        <h1 class="sr-only">Organisations</h1>
        <div class="flex flex-col space-y-6">
            <Heading
                description="List of all registered organisations"
                title="Organisations"
                variant="small"
            />
            <div class="overflow-x-auto">
                <GoogleMap
                    :api-key="apiKey"
                    :center="{
                        lat: 52.61426664444087,
                        lng: 1.2995043404412898,
                    }"
                    :zoom="10"
                    map-id="DEMO_MAP_ID"
                    style="width: 100%; height: 400px"
                >
                    <MarkerCluster>
                        <AdvancedMarker
                            v-for="(organisation, i) in organisations"
                            :key="i"
                            :options="{
                                position: {
                                    lat: parseFloat(organisation.lat),
                                    lng: parseFloat(organisation.lng),
                                },
                                title: organisation.name.toUpperCase(),
                                gmpClickable: true,
                            }"
                            :pin-options="{
                                background: 'lightblue',
                                glyphColor: '#000000',
                                glyphSrc: '/images/scissors-solid-full.svg',
                            }"
                            @click="showOrg(organisation.id)"
                        />
                    </MarkerCluster>
                </GoogleMap>
                <!--                <table class="table">-->
                <!--                    &lt;!&ndash; head &ndash;&gt;-->
                <!--                    <thead>-->
                <!--                        <tr>-->
                <!--                            <th>Name</th>-->
                <!--                            <th>Contact</th>-->
                <!--                            <th>Postcode</th>-->
                <!--                            <th></th>-->
                <!--                        </tr>-->
                <!--                    </thead>-->
                <!--                    <tbody>-->
                <!--                        &lt;!&ndash; row 1 &ndash;&gt;-->
                <!--                        <tr-->
                <!--                            v-for="organisation in organisations"-->
                <!--                            v-bind:key="organisation.id"-->
                <!--                        >-->
                <!--                            <td>-->
                <!--                                {{ organisation.name }}-->
                <!--                            </td>-->
                <!--                            <td>-->
                <!--                                {{ organisation.admin_name }}-->
                <!--                                <br />-->
                <!--                                <span class="badge badge-ghost badge-sm">{{-->
                <!--                                    organisation.email-->
                <!--                                }}</span>-->
                <!--                            </td>-->
                <!--                            <td>{{ organisation.postcode }}</td>-->
                <!--                            <th>-->
                <!--                                <Link-->
                <!--                                    :href="show(organisation.id)"-->
                <!--                                    class="text-xs text-neutral-500 hover:text-neutral-100"-->
                <!--                                >-->
                <!--                                    details<span class="sr-only"-->
                <!--                                        >, {{ organisation.name }}</span-->
                <!--                                    >-->
                <!--                                </Link>-->
                <!--                            </th>-->
                <!--                        </tr>-->
                <!--                    </tbody>-->
                <!--                </table>-->
            </div>
        </div>
    </div>
</template>
