<?php

namespace App\Services;

use App\Models\Organisation;
use phpDocumentor\Reflection\Types\Integer;

class StudentAvailabilityService
{
    public function getAvailableStudents(
        Organisation $organisation,
        Integer $day,
    ): array {
        return $organisation->students;
    }
}
