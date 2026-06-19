<script setup lang="ts">
import { LucideIcon } from '@lucide/vue';

interface Props {
    iconName: LucideIcon | undefined
}

const props = defineProps<Props>()

</script>

<template>
  <component :is="props.iconName" />
</template>

<style scoped>

</style>
