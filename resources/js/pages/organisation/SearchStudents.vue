<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { getDay } from 'date-fns';
import type { Ref } from 'vue';
import { watch } from 'vue';
import { computed, ref } from 'vue';
import DatePicker from '@/components/DatePicker.vue';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import organisations from '@/routes/organisations';
import { index } from '@/routes/shifts';

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

watch(
    () => !isNaN(selectedDay.value),
    async () => {
        const response = await axios.get(
            '/api/organisations/' + props.salon.id + '/students/available',
            {
                params: {
                    day: selectedDay.value,
                    salon: props.salon.id,
                },
            },
        );
        console.log(response.data);
        availableStudents.value = response.data;
    },
);
// const availableStudents: Promise<AxiosResponse<any>> | null = !isNaN(
//     selectedDate.value,
// )
//     ? axios.get('/api/students/available', {
//           params: {
//               day: selectedDay.value,
//               salon: props.salon.id,
//           },
//       })
//     : null;

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
                        <table class="border-spacing-2">
                            <thead>
                                <tr>
                                    <td>Student</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="student in availableStudents"
                                    :key="student.id"
                                    class="text-sm text-muted-foreground"
                                >
                                    <td>
                                        <Link
                                            :href="
                                                '/students/' +
                                                student.id +
                                                '/appointments'
                                            "
                                            >{{ student.name }}</Link
                                        >
                                    </td>
                                    <td
                                        v-for="service in student.services"
                                        :key="service.id"
                                    >
                                        <Badge variant="secondary"
                                            >{{ service.name }}
                                        </Badge>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
