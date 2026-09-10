<?php

namespace App\Services;

use App\Domain\Appointment\DTO\AppointmentDTO;
use App\Domain\Appointment\DTO\ScheduleItemDTO;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentService
{
    public function createAppointment(AppointmentDTO $appointmentDTO): Appointment
    {
        $appointment = new Appointment;

        $appointment->student = $appointmentDTO->student;
        $appointment->client = $appointmentDTO->client;
        $appointment->date = $appointmentDTO->date;
        $appointment->time = $appointmentDTO->time;
        $appointment->service_id = $appointmentDTO->service_id;
        $appointment->status = $appointmentDTO->status;
        $appointment->save();

        return $appointment;
    }

    public function getAppointments($student, $date): array
    {
        return $this->getAppointmentsAsDTO(
            Appointment::where(['student' => $student, 'date' => $date])
                ->with(['client:id,name', 'service:name,min_duration,id'])
                ->get());
    }

    private function getAppointmentsAsDTO($appointments): array
    {
        $appointments = $appointments->toArray();
        $apps = [];
        foreach ($appointments as $appointment) {
            $apps[] = new ScheduleItemDTO(
                $appointment['id'],
                $appointment['date'],
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
