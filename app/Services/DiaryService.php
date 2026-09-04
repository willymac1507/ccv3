<?php

namespace App\Services;

use App\Domain\Appointment\DTO\DiaryDTO;
use App\Domain\Appointment\DTO\ScheduleItemDTO;
use App\Models\Appointment;
use App\Models\Shift;
use Carbon\Carbon;

class DiaryService
{
    public function createDiary($student, $date): DiaryDTO
    {
        $shift = $this->getShift($student, $date);
        $appointments = $this->schedule($student->id, $date, $shift);

        return new DiaryDTO($student, $shift, $appointments, new Carbon($date));
    }

    private function getShift($user, $date): ?Shift
    {
        return Shift::where(['user_id' => $user->id, 'day' => Carbon::parse($date)->format('l')])->first();
    }

    private function schedule($student, $date, $shift): array
    {
        $appointments = [];
        foreach ($this->getAppointments($student, $date) as $appointment) {
            $appointments[] = $appointment;
        }
        $appointments[] = $this->makeSetupBlock($shift);
        $appointments[] = $this->makeCleanupBlock($shift);
        if (isset($shift['breakTime'])) {
            $appointments[] = $this->makeBreakBlock($shift);
        }

        return $appointments;
    }

    private function getAppointments($student, $date): array
    {
        return $this->getAppointmentsAsArray(
            Appointment::where(['student' => $student, 'date' => new Carbon($date)])
                ->with(['client:id,name', 'service:name,min_duration,id'])
                ->get());
    }

    private function getAppointmentsAsArray($appointments): array
    {
        $appointments = $appointments->toArray();
        $apps = [];
        foreach ($appointments as $appointment) {
            $apps[] = new ScheduleItemDTO(
                $appointment['id'],
                $appointment['time'],
                $appointment['student'],
                $appointment['client']['id'],
                $appointment['client']['name'],
                $appointment['service']['name'],
                $appointment['service']['min_duration'],
                $appointment['status']
            );
        }

        return $apps;
    }

    private function makeSetupBlock($shift): ScheduleItemDTO
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

    private function makeCleanupBlock($shift): ScheduleItemDTO
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

    private function makeBreakBlock($shift): ScheduleItemDTO
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
