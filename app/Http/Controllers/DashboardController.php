<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use JetBrains\PhpStorm\NoReturn;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointmentsAsStudent = Appointment::query()
            ->where(
                'student', auth()->id())
            ->when(request('date'), function ($query, $date) {
                $query->where('date', $date);
            }, function ($query) {
                $query->where('date', now()->toDateString());
            })
            ->orderBy('time', 'ASC')
            ->with('client')
            ->get();

        return Inertia::render('Dashboard', [
            'appointmentsAsStudent' => $appointmentsAsStudent,
            'date' => request('date') ?? Carbon::now()->toDateString(),
        ]);
    }

    #[NoReturn]
    public function updateServices(Request $request)
    {
        $appointmentsAsStudent = Appointment::query()
            ->where(
                'student', auth()->id())
            ->when(request('date'), function ($query, $date) {
                $query->where('date', $date);
            }, function ($query) {
                $query->where('date', now()->toDateString());
            })
            ->orderBy('time', 'ASC')
            ->with('client')
            ->get();

        return Inertia::render('Dashboard', [
            'appointmentsAsStudent' => $appointmentsAsStudent,
            'date' => request('date') ?? Carbon::now()->toDateString(),
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
