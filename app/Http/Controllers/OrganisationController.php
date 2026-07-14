<?php

namespace App\Http\Controllers;

use App\Concerns\Organisations;
use App\Concerns\Students;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrganisationController extends Controller
{
    use Organisations;
    use Students;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('organisation/Index', [
            'organisations' => Organisation::all(),
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
    public function show(Organisation $organisation)
    {
        return Inertia::render('organisation/Show', [
            'organisation' => $organisation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organisation $organisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organisation $organisation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organisation $organisation)
    {
        //
    }

    public function search()
    {
        $organisations = $this->getAllOrganisations()->select(['id', 'name', 'postcode', 'lat', 'lng']);
        $favouriteOrgs = $this->getFavouriteOrganisations(Auth::user())->select(['id', 'name', 'postcode', 'lat', 'lng']);
        return Inertia::render('organisation/Search', [
            'salons' => $organisations,
            'favouriteSalons' => $favouriteOrgs,
        ]);
    }

    public function availableStudents(Organisation $organisation)
    {
        return Inertia::render('organisation/SearchStudents', ['salon' => $organisation]);
    }

    public function getAvailable(Request $request)
    {
        return $this->getAvailableStudents($request->salon, $request->day);
    }
}
