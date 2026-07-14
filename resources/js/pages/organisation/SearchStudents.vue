<script lang="ts" setup>
import { Head, Link, useHttp } from '@inertiajs/vue3';
import { format, getDay } from 'date-fns';
import type { Ref } from 'vue';
import { watch } from 'vue';
import { computed, ref } from 'vue';
import DatePicker from '@/components/DatePicker.vue';
import Heading from '@/components/Heading.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import organisations from '@/routes/organisations';
import { index } from '@/routes/shifts';

interface HttpForm {
    salon: number;
    day: number;
}

interface HttpResponse {
    id: number;
    name: string;
}
interface Props {
    salon: Salon;
}

interface Salon {
    id: number;
    name: string;
    address1: string;
    postcode: string;
    email: string;
    phone: string;
    students: Array<Student>;
}

interface Student {
    id: number;
    name: string;
    services: Array<any>;
    shifts: Array<any>;
}

const props = defineProps<Props>();

const selectedDate = ref();
const selectedDay = computed(() => {
    if (getDay(selectedDate.value) === 0) {
        return 7;
    } else {
        return getDay(selectedDate.value);
    }
});

const availableStudents: Ref = ref([]);

const http = useHttp<HttpForm, HttpResponse>({
    salon: props.salon.id,
    day: 0,
});

watch(selectedDate, getAvailableStudents);

function getAvailableStudents() {
    http.day = selectedDay.value;
    http.get('/api/organisations/students/available', {
        onSuccess: (response) => {
            availableStudents.value = response;
        },
    });
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Salons',
                href: organisations.search(),
            },
            {
                title: 'Available students',
                href: index(),
            },
        ],
    },
});
</script>

<template>
    <div class="px-4 py-6">
        <Head title="Available students" />

        <h1 class="sr-only">Available Students</h1>

        <div class="flex flex-col space-y-6">
            <Heading
                description="Find available students at selected salon"
                title="Available Students"
                variant="small"
            />
            <Card>
                <CardHeader>
                    <div class="flex justify-between">
                        <div>
                            <CardTitle>{{ salon.name }}</CardTitle>
                            <CardDescription>
                                <div class="flex flex-col">
                                    <span>{{ salon.address1 }}</span>
                                    <span>{{ salon.postcode }}</span>
                                    <span>{{ salon.email }}</span>
                                    <span>{{ salon.phone }}</span>
                                </div>
                            </CardDescription>
                        </div>
                        <DatePicker v-model="selectedDate" />
                    </div>
                </CardHeader>
                <CardContent v-if="selectedDate">
                    <div v-if="availableStudents.length" class="flex flex-col">
                        <p class="mb-2 font-bold">Available Students</p>
                        <div
                            class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100"
                        >
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Services Offered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr
                                        v-for="student in availableStudents"
                                        :key="student.id"
                                    >
                                        <td>
                                            <Link
                                                :data="{
                                                    date: format(
                                                        selectedDate,
                                                        'yyyy-MM-dd',
                                                    ),
                                                }"
                                                :href="
                                                    '/students/' +
                                                    student.id +
                                                    '/appointments'
                                                "
                                                method="get"
                                                view-transition
                                                >{{ student.name }}</Link
                                            >
                                        </td>
                                        <td>
                                            <div
                                                v-for="service in student.services"
                                                v-bind:key="service.id"
                                                class="mr-2 badge badge-soft px-2 badge-secondary"
                                            >
                                                {{ service.name }}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="!availableStudents.length">
                        <p class="mb-2 font-bold">
                            Sorry, no students are available on that day.
                        </p>
                    </div>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
