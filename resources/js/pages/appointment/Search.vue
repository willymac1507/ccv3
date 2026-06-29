<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Multiselect from 'vue-multiselect';
import Heading from '@/components/Heading.vue';

interface Salon {
    id: number;
    name: string;
    postcode: string;
}

interface Props {
    salons: Array<Salon>;
}
const props = defineProps<Props>();
const salonsList = props.salons.map(
    (salon) => salon.name + ' : ' + salon.postcode,
);

const salonsSelected = ref([]);

console.log(props.salons);
</script>

<template>
    <Head title="Services" />

    <h1 class="sr-only">Services</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            description="Search for an appointment"
            title="Appointment Search"
            variant="small"
        />
        <form action="" class="grid items-center space-y-6 px-6">
            <label for="salons">
                <multiselect
                    id="salons"
                    v-model="salonsSelected"
                    :close-on-select="false"
                    :options="salonsList"
                    multiple
                    name="salons"
                    placeholder="Select salons near you"
                ></multiselect>
            </label>
            <label for="dateTime">

            </label>
        </form>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
