<?php

namespace App\Domain\Appointment\Diary\Loaders;

use App\Domain\Appointment\DTO\ScheduleItemDTO;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentLoader
{
    public function getAppointments($student, $date): array
    {
        return $this->getAppointmentsAsArray(
            Appointment::where(['student' => $student, 'date' => new Carbon($date)])
                ->with(['client:id,name', 'service:name,min_duration,id'])
                ->get());
    }

    private function getAppointmentsAsArray($appointments): array
    {
        $appointments = $appointments->toArray();
        $apps = [];
        foreach ($appointments as $appointment) {
            $apps[] = new ScheduleItemDTO(
                $appointment['id'],
                $appointment['time'],
                $appointment['student'],
                $appointment['client']['id'],
                $appointment['client']['name'],
                $appointment['service']['name'],
                $appointment['service']['min_duration'],
                $appointment['status']
            );
        }

        return $apps;
    }
}
