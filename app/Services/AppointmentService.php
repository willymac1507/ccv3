<?php

namespace App\Services;

use App\Domain\Appointment\DTO\AppointmentDTO;
use App\Models\Appointment;

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
}
