<?php

namespace App\Domain\Appointment\Diary\Loaders;

use App\Domain\Appointment\DTO\ScheduleItemDTO;
use Carbon\Carbon;

class BusytimeLoader
{
    public function makeSetupBlock($shift): ScheduleItemDTO
    {
        return new ScheduleItemDTO(
            null,
            $shift->startTime,
            $shift->user_id,
            null,
            'Setup',
            'Setup',
            1,
            ''
        );
    }

    public function makeCleanupBlock($shift): ScheduleItemDTO
    {
        return new ScheduleItemDTO(
            null,
            new Carbon($shift['endTime'])->subMinutes(15)->format('H:i:s'),
            $shift->user_id,
            null,
            'Cleanup',
            'Cleanup',
            1,
            ''
        );
    }

    public function makeBreakBlock($shift): ScheduleItemDTO
    {
        return new ScheduleItemDTO(
            null,
            $shift['breakTime'],
            $shift->user_id,
            null,
            'Break',
            'Break',
            $shift['duration'] / 15,
            ''
        );
    }
}
