<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
import TimeSlotLayout from '@/components/TimeSlotLayout.vue';

const form = ref(useForm({
    monday: [],
}));
</script>

<template>
    <Head title="Time Slots" />

    <h1 class="sr-only">Time Slots</h1>

    <div class="flex flex-col space-y-6">
        <Heading
            variant="small"
            title="Time Slots"
            description="Select when you will be available"
        />
        <form @submit.prevent="form.patch('/settings/slots')">
            <TimeSlotLayout>
                <template #monday>
                    <input type="checkbox" value="monam1" name="monday[]" v-model="form.monday" class="checkbox checkbox-sm border border-gray-400">
                    <input type="checkbox" value="monpm1" name="monday[]" v-model="form.monday" class="checkbox checkbox-sm border border-gray-400">
                    <input type="checkbox" value="monam2" name="monday[]" v-model="form.monday" class="checkbox checkbox-sm border border-gray-400">
                    <input type="checkbox" value="monpm2" name="monday[]" v-model="form.monday" class="checkbox checkbox-sm border border-gray-400">
                    <input type="checkbox" value="monam3" name="monday[]" v-model="form.monday" class="checkbox checkbox-sm border border-gray-400">
                    <input type="checkbox" value="monpm3" name="monday[]" v-model="form.monday" class="checkbox checkbox-sm border border-gray-400">
                </template>
            </TimeSlotLayout>
        </form>
    </div>
</template>
