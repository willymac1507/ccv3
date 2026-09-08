<?php

namespace App\Domain\Appointment\DTO;

readonly class ScheduleItemDTO
{
    public function __construct(
        public ?int   $id,
        public string $time,
        public int    $student,
        public ?int   $client,
        public string $clientName,
        public string $service,
        public int    $duration,
        public string $status,
    )
    {
    }
}
