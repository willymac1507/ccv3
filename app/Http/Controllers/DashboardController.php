<?php

namespace App\Http\Controllers;

use App\Services\AppointmentService;
use App\Services\MessageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private readonly AppointmentService $appointmentservice,
        private readonly MessageService $messageservice,
    ) {}

    public function index()
    {
        $date = request('date') ?? Carbon::now()->toDateString();
        $appointmentsAsStudent = $this->appointmentservice->getAppointments(auth()->id(), $date);

        return Inertia::render('Dashboard', [
            'appointmentsAsStudent' => $appointmentsAsStudent,
            'date' => $date,
            'unreadMessages' => $this->messageservice->getUnread(auth()->id()),
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
