<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import DatePicker from '@/components/DatePicker.vue';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

interface Props {
    salons: Array<any>;
}

defineProps<Props>();
</script>

<template>
    <div class="px-4 py-6">
        <Head title="Appointment.Search" />

        <h1 class="sr-only">Appointment search</h1>

        <div class="flex flex-col space-y-6">
            <Heading
                description="Search for appointments at selected salons"
                title="Appointment Search"
                variant="small"
            />
            <Card v-for="salon in salons" :key="salon.id">
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
                        <DatePicker />
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="flex flex-col">
                        <p class="mb-2 font-bold">Students</p>
                        <table class="border-spacing-2">
                            <tr>
                                <td>Student</td>
                            </tr>
                            <tr
                                v-for="student in salon.students"
                                :key="student.id"
                                class="text-sm text-muted-foreground"
                            >
                                <td>{{ student.name }}</td>
                                <td
                                    v-for="service in student.services"
                                    :key="service.id"
                                >
                                    <Badge variant="secondary"
                                        >{{ service.name }}
                                    </Badge>
                                </td>
                            </tr>
                        </table>
                    </div>
                </CardContent>
                <CardFooter> Footer</CardFooter>
            </Card>
        </div>
    </div>
</template>
