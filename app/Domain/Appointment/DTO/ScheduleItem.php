<?php

namespace App\Domain\Appointment\DTO;

use Carbon\Carbon;

readonly class ScheduleItem
{
    public function __construct(
        public string $time,
        public int    $student,
        public string $client,
        public string $service,
        public int    $duration,
        public string $status,
    )
    {
    }
}
