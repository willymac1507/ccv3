<?php

namespace App\Domain\Appointment\DTO;

readonly class ScheduleItem
{
    public function __construct(
        public ?int $id,
        public string $time,
        public int $student,
        public string $client,
        public string $service,
        public int $duration,
        public string $status,
    ) {}
}
