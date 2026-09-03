<?php

namespace App\Domain\Appointment\Diary\Loaders;

use App\Domain\Appointment\DTO\ScheduleItem;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentLoader
{
    public function getAppointments($student, $date): array
    {
        return $this->getAppointmentsAsArray(
            Appointment::where(['student' => $student, 'date' => new Carbon($date)])
                ->with(['client:name,id', 'service'])
                ->get());
    }

    private function getAppointmentsAsArray($appointments): array
    {
        $appointments = $appointments->toArray();
        $apps = [];
        foreach ($appointments as $appointment) {
            $apps[] = new ScheduleItem(
                $appointment['time'],
                $appointment['student'],
                $appointment['client']['name'],
                $appointment['service']['name'],
                $appointment['service']['min_duration'],
                $appointment['status']
            );
        }

        return $apps;
    }
}
