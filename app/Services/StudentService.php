<?php

namespace App\Services;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LaravelIdea\Helper\App\Models\_IH_Organisation_C;

readonly class StudentService
{
    public function getAvailableStudents($organisation, $day): Model|Collection|array|_IH_Organisation_C|Organisation|null
    {
        return User::where('organisation_id', $organisation)
            ->whereHas('shifts', function ($query) use ($day) {
                $query->where('dayNumber', $day)
                    ->whereNotNull('startTime');
            })
            ->with('services')
            ->get();

    }
}
