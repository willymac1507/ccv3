<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use JetBrains\PhpStorm\NoReturn;
use Random\RandomException;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Search for an appointment from one or more salons.
     *
     * @throws RandomException
     */
    #[NoReturn]
    public function search(Request $request)
    {
        $salonIds = array_column($request->salons, 'id');
        $salons = Organisation::query()
            ->whereIn('id', $salonIds)
            ->with('students')
            ->with('students.services')
            ->with('students.shifts')
            ->get();

        return Inertia::render('appointment/Search', ['salons' => $salons]);
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
