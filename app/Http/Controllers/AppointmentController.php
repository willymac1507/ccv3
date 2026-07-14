<?php

namespace App\Http\Controllers;

use App\Concerns\Organisations;
use App\Models\Appointment;
use App\Models\Shift;
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
    public function index(User $user)
    {
        $appointments = $this->getAppointmentsAsArray(Appointment::where(['student' => $user->id, 'date' => request('date')])
            ->with('client:name,id')
            ->get());
        $student = User::find($user->id);
        $shift = Shift::where(['user_id' => $user->id, 'day' => Carbon::parse(request('date'))->format('l')])->first();
        if ($shift['breakTime']) {
            $break = [
                'id' => 999999999999999999,
                'date' => request('date'),
                'time' => $shift['breakTime'],
                'duration' => $shift['duration'] / 15,
                'student' => $user->id,
                'client' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
                'description' => 'Break',
                'status' => '',
            ];
            $appointments[] = $break;
        }

        return Inertia::render('appointment/Index', [
            'student' => $student,
            'appointments' => $appointments ?? '',
            'shift' => $shift,
            'date' => new Carbon(request('date')),
        ]);
    }

    private function getAppointmentsAsArray($appointments)
    {
        return $appointments->toArray();
    }

    public function showStudentAppointments(User $user, Request $request)
    {
        //
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
