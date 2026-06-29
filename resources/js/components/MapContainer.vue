<script lang="ts" setup>
import H from '@here/maps-api-for-javascript';
import '@here/maps-api-for-javascript/venues';

const apiKey = import.meta.env.VITE_HERE_API_KEY;
console.log(apiKey);
const platform = new H.service.Platform({
    apikey: apiKey,
});
</script>

<template>
    <div id="mapContainer" class="h-175 w-full"></div>
</template>

<style scoped></style>
