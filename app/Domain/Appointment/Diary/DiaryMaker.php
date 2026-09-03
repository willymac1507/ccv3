<?php

namespace App\Domain\Appointment\Diary;

use App\Domain\Appointment\Diary\Loaders\AppointmentLoader;
use App\Domain\Appointment\Diary\Loaders\BusytimeLoader;
use App\Domain\Appointment\Diary\Loaders\ShiftLoader;

class DiaryMaker
{
    public function schedule($student, $date, $shift): array
    {
        $appointments = [];
        foreach (new AppointmentLoader()->getAppointments($student, $date) as $appointment) {
            $appointments[] = $appointment;
        }
        $appointments[] = new BusytimeLoader()->makeSetupBlock($shift);
        $appointments[] = new BusytimeLoader()->makeCleanupBlock($shift);
        if (isset($shift['breakTime'])) {
            $appointments[] = new BusytimeLoader()->makeBreakBlock($shift);
        }

        return $appointments;
    }
}
