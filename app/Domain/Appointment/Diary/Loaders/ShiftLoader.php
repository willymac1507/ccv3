<?php

namespace App\Domain\Appointment\Diary\Loaders;

use App\Models\Shift;
use Carbon\Carbon;

class ShiftLoader
{
    public function getShift($user, $date): ?Shift
    {
        return Shift::where(['user_id' => $user->id, 'day' => Carbon::parse($date)->format('l')])->first();
    }
}
