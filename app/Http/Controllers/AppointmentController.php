<?php

namespace App\Http\Controllers;

use App\Concerns\Organisations;
use App\Domain\Appointment\Diary\DiaryMaker;
use App\Domain\Appointment\Diary\Loaders\ShiftLoader;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    use Organisations;

    /**
     * Display a listing of the resource.
     */
    public function index(User $student)
    {
        $shift = new ShiftLoader()->getShift($student, request('date'));
        $appointments = new DiaryMaker()->schedule($student->id, request('date'), $shift);

        return Inertia::render('appointment/Index', [
            'student' => $student,
            'shift' => $shift,
            'appointments' => $appointments,
            'date' => new Carbon(request('date')),
        ]);
    }

    public function showStudentAppointments(User $user, Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $appointment = Appointment::create($request->all());
        $appointment->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

    private function getAppointmentsAsArray($appointments)
    {
        return $appointments->toArray();
    }
}
