<?php

namespace App\Domain\Appointment\DTO;

use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class DiaryDTO implements Arrayable
{
    public function __construct(
        public User   $student,
        public Shift  $shift,
        public array  $appointments,
        public Carbon $date,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'student' => $this->student,
            'shift' => $this->shift,
            'appointments' => $this->appointments,
            'date' => $this->date,
        ];
    }
}
