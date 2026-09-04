<?php

namespace App\Http\Controllers;

use App\Domain\Appointment\DTO\AppointmentDTO;
use App\Models\Appointment;
use App\Models\User;
use App\Services\AppointmentService;
use App\Services\DiaryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $appointmentService,
        private readonly DiaryService $diaryService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(User $student)
    {
        $diary = $this->diaryService->createDiary($student, request('date'));

        return Inertia::render('appointment/Index', $diary->toArray());
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
        $appointmentDTO = new AppointmentDTO(
            $request->input('student'),
            $request->input('client'),
            $request->input('date'),
            $request->input('time'),
            $request->input('service_id'),
            'pending'
        );

        $appointment = $this->appointmentService->createAppointment($appointmentDTO);

        return redirect()->route('students.appointments.index', [$appointment->student,
            'date' => $appointment->date, ]);
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
