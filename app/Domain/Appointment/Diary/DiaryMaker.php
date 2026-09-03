<?php

namespace App\Domain\Appointment\Diary;

use App\Domain\Appointment\Diary\Loaders\AppointmentLoader;
use App\Domain\Appointment\Diary\Loaders\BusytimeLoader;
use App\Domain\Appointment\Diary\Loaders\ShiftLoader;
use Carbon\Carbon;

class DiaryMaker
{
    public function schedule($student, $date): void
    {
        $appointments = [];
        $shift = ShiftLoader::getShift($student, $date);
        $appointments = AppointmentLoader::getAppointments($student, $date);
        $appointments = BusytimeLoader::makeSetupBlock($shift);
        $appointments = BusytimeLoader::makeCleanupBlock($shift);
        $appointments = isset($shift['breakTime']) ?? BusytimeLoader::makeBreakBlock($shift);
    }
}
