<?php

namespace App\Http\Controllers;

use App\Concerns\Organisations;
use App\Models\Appointment;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Random\RandomException;

class AppointmentController extends Controller
{
    use Organisations;

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $student = User::with(['organisation'])->find($user->id);

        return Inertia::render('appointment/Index');
    }

    /**
     * Search for an appointment from one or more salons.
     *
     * @throws RandomException
     */
    public function searchStudents(Organisation $organisation)
    {
        $salon = $this->getOrganisationWithStudents($organisation->id);

        return Inertia::render('appointment/SearchStudents', ['salon' => $salon]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
