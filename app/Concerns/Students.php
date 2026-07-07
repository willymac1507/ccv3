<?php

namespace App\Concerns;

use App\Models\Organisation;

trait Students
{
    public function getAvailableStudents(Organisation $organisation)
    {
        return $organisation->students;
    }
}
