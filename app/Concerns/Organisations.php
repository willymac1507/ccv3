<?php

namespace App\Concerns;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LaravelIdea\Helper\App\Models\_IH_Organisation_C;

trait Organisations
{
    public function getAllOrganisations(): Collection|array|_IH_Organisation_C
    {
        return Organisation::all();
    }

    public function getOrganisationWithStudents($org_id): Model|Collection|array|_IH_Organisation_C|Organisation|null
    {
        return Organisation::with(['students', 'students.services', 'students.shifts'])->find($org_id);
    }

    public function getFavouriteOrganisations(User $user): Model|Collection|array|_IH_Organisation_C|Organisation|null
    {
        return $user->favouriteOrganisations;
    }
}
