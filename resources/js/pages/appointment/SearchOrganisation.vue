<script lang="ts" setup>
import { setOptions, importLibrary } from '@googlemaps/js-api-loader';
import { Head, router } from '@inertiajs/vue3';
import type { Ref } from 'vue';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { AdvancedMarker, GoogleMap, MarkerCluster } from 'vue3-google-map';
import Heading from '../../components/Heading.vue';
import organisations from '../../routes/organisations';

let geocoder: any;
let position: LatLng;
const centerLocation: Ref<string> = ref('');
const centerCoords: Ref = ref({ lat: 0, lng: 0 });
const mapReady: Ref = ref(false);
ref([]);

onMounted(async () => {
    setOptions({ key: import.meta.env.VITE_GOOGLE_MAPS_API_KEY });
    const { Geocoder } = await importLibrary('geocoding');
    geocoder = new Geocoder();
});

async function geocode(
    request: GeocoderRequestAddress | GeocoderRequestLatLng,
) {
    try {
        const response = await geocoder.geocode(request);
        const { results } = response;
        position = {
            lat: results[0].geometry.location.lat(),
            lng: results[0].geometry.location.lng(),
        };
        mapReady.value = true;

        return position;
    } catch (e) {
        alert(
            'Geocode was not successful for the following reason: ' + String(e),
        );
    }
}

function selectSalon(id: number) {
    router.get('/organisations/' + id + '/appointments/search');
    // if (salonsSelected.value.find((salon) => salon.id === id)) {
    //     const indexToDelete = salonsSelected.value.findIndex(
    //         (salon) => salon.id === id,
    //     );
    //     salonsSelected.value.splice(indexToDelete, 1);
    // } else {
    //     salonsSelected.value.push({ id: id, name: name });
    // }
}

async function findCoords() {
    if (centerLocation.value.length > 0) {
        await geocode({ address: centerLocation.value }).then((coords) => {
            centerCoords.value = coords;
        });
    }
}

interface Salon {
    id: number;
    name: string;
    postcode?: string;
    lat?: string;
    lng?: string;

    [key: string]: any;
}

interface SalonPartial extends Salon {
    id: number;
    name: string;
    postcode?: never;
    lat?: never;
    lng?: never;

    [key: string]: any;
}

interface SalonFull extends Salon {
    id: number;
    name: string;
    postcode: string;
    lat: string;
    lng: string;

    [key: string]: any;
}

interface LatLng {
    lat: number;
    lng: number;
}

interface Props {
    salons: Array<SalonFull>;
}

interface GeocoderRequest {
    bounds?: string;
    region?: string;
    placeId?: string;
    componentRestrictions?: string;
}

interface GeocoderRequestAddress extends GeocoderRequest {
    address: string;
    location?: never;
}

interface GeocoderRequestLatLng extends GeocoderRequest {
    address?: never;
    location: string;
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Salon search',
                href: organisations.search(),
            },
        ],
    },
});

defineProps<Props>();
</script>

<template>
    <div class="px-4 py-6">
        <Head title="Salon.Search" />

        <h1 class="sr-only">Salon search</h1>

        <div class="flex flex-col space-y-6">
            <Heading
                description="Search for salons near you"
                title="Salon Search"
                variant="small"
            />
            <div class="flex flex-row justify-start">
                <input
                    v-model="centerLocation"
                    class="input"
                    placeholder="Enter postcode or full address"
                    type="text"
                />
                <button
                    class="btn btn-active ml-4 cursor-pointer"
                    @click="findCoords()"
                >
                    Search
                </button>
            </div>

            <div v-if="mapReady">
                <div class="mb-6 text-sm text-muted-foreground">
                    Select a nearby salon by clicking on the map pin. If no
                    salons are visible, try zooming out.
                </div>
                <GoogleMap
                    :center="centerCoords"
                    :zoom="10"
                    map-id="DEMO_MAP_ID"
                    style="width: 100%; height: 400px"
                >
                    <AdvancedMarker
                        :options="{
                            position: centerCoords,
                        }"
                        :pin-options="{
                            background: 'lightgreen',
                            glyphColor: '#000000',
                            glyphSrc:
                                '/images/hand-point-down-regular-full.svg',
                        }"
                    />
                    <MarkerCluster>
                        <AdvancedMarker
                            v-for="(salon, i) in salons"
                            :key="i"
                            :options="{
                                position: {
                                    lat: parseFloat(salon.lat),
                                    lng: parseFloat(salon.lng),
                                },
                                gmpClickable: true,
                            }"
                            :pin-options="{
                                background: 'lightblue',
                                glyphColor: '#000000',
                                glyphSrc: '/images/scissors-solid-full.svg',
                            }"
                            @click="selectSalon(salon.id)"
                        >
                        </AdvancedMarker>
                    </MarkerCluster>
                </GoogleMap>
            </div>
        </div>
    </div>
</template>

<style
    src="../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"
></style>
