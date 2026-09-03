<?php

namespace App\Domain\Appointment\Diary\Loaders;

use App\Domain\Appointment\DTO\ScheduleItem;
use Carbon\Carbon;

class BusytimeLoader
{
    public function makeSetupBlock($shift): ScheduleItem
    {
        return new ScheduleItem(
            null,
            $shift->startTime,
            $shift->user_id,
            'Setup',
            'Setup',
            1,
            ''
        );
    }

    public function makeCleanupBlock($shift): ScheduleItem
    {
        return new ScheduleItem(
            null,
            new Carbon($shift['endTime'])->subMinutes(15)->format('H:i:s'),
            $shift->user_id,
            'Cleanup',
            'Cleanup',
            1,
            ''
        );
    }

    public function makeBreakBlock($shift): ScheduleItem
    {
        return new ScheduleItem(
            null,
            $shift['breakTime'],
            $shift->user_id,
            'Break',
            'Break',
            $shift['duration'] / 15,
            ''
        );
    }
}
