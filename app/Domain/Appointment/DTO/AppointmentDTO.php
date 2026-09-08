<?php

namespace App\Domain\Appointment\DTO;

readonly class AppointmentDTO
{
    public function __construct(
        public int $student,
        public int $client,
        public string $date,
        public string $time,
        public int $service_id,
        public string $status = 'pending',
    ) {}
}
