<?php

namespace App\Http\Controllers;

use App\Concerns\Organisations;
use App\Domain\Appointment\Diary\Loaders\AppointmentLoader;
use App\Domain\Appointment\Diary\Loaders\BusytimeLoader;
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
    public function index(User $student)
    {
        $appointments = new AppointmentLoader()->getAppointments($student->id, request('date'));

        $shift = Shift::where(['user_id' => $student->id, 'day' => Carbon::parse(request('date'))->format('l')])->first();
        dd($appointments, new BusytimeLoader()->makeSetupBlock($shift));
        $cleanUpTime = new Carbon($shift['endTime'])->subMinutes(15)->format('H:i:s');
        $setUpAppt = [
            'id' => 999999999999999997,
            'date' => request('date'),
            'time' => $shift['startTime'],
            'student' => $student->id,
            'client' => [
                'id' => $student->id,
                'name' => $student->name,
            ],
            'service' => [
                'id' => 100,
                'name' => 'Set up',
                'min_duration' => 1,
            ],
            'status' => '',
        ];
        $appointments[] = $setUpAppt;
        $cleanUpAppt = [
            'id' => 999999999999999998,
            'date' => request('date'),
            'time' => $cleanUpTime,
            'student' => $student->id,
            'client' => [
                'id' => $student->id,
                'name' => $student->name,
            ],
            'service' => [
                'id' => 100,
                'name' => 'Clean up',
                'min_duration' => 1,
            ],
            'status' => '',
        ];
        $appointments[] = $cleanUpAppt;
        if ($shift['breakTime']) {
            $break = [
                'id' => 999999999999999999,
                'date' => request('date'),
                'time' => $shift['breakTime'],
                'student' => $student->id,
                'client' => [
                    'id' => $student->id,
                    'name' => $student->name,
                ],
                'service' => [
                    'id' => 100,
                    'name' => 'Break',
                    'min_duration' => $shift['duration'] / 15,
                ],
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
