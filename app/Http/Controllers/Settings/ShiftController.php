<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ShiftUpdateRequest;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = auth()->user()->shifts()->orderBy('dayNumber', 'asc')->get();

        return Inertia::render('settings/Shifts/Index');
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
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShiftUpdateRequest $request, Shift $shift)
    {
        $user = User::find($request->user()->id);

        foreach ($request->all() as $shift) {
            Shift::upsert([
                'uuid' => $shift['uuid'],
                'user_id' => $user->id,
                'day' => $shift['day'],
                'dayNumber' => $shift['dayNumber'],
                'startTime' => $shift['start'],
                'endTime' => $shift['end'],
                'breakTime' => $shift['break'],
                'duration' => $shift['breakDuration'],
            ], uniqueBy: ['user_id', 'day'],
                update: ['startTime', 'endTime', 'breakTime', 'duration']);
        }
        Inertia::flash('toast', ['type' => 'success', 'message' => __('Shifts updated.')]);

        return to_route('shifts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
    }
}
