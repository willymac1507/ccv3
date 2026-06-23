<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the user's service settings page.
     */
    public function edit()
    {
        return inertia('settings/Services');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = User::find($request->user()->id);
        $servicesSelected = $request->selectedServices;
        foreach ($servicesSelected as $service) {
            $user->services()->sync($servicesSelected);
        }
        Inertia::flash('toast', ['type' => 'success', 'message' => __('Services updated.')]);

        return to_route('services.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
