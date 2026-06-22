<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Service;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function setNavItems(Request $request): ?array
    {
        $standardNavItems = [
            [
                'title' => 'Dashboard',
                'href' => '/dashboard',
                'icon' => 'fa-solid fa-tachograph-digital',
            ],
            [
                'title' => 'Appointments',
                'href' => '#',
                'icon' => 'fa-solid fa-calendar-days',
            ],
            [
                'title' => 'Messages',
                'href' => '#',
                'icon' => 'fa-solid fa-envelope',
            ],
        ];

        $superAdminNavItems = [
            [
                'title' => 'Organisations',
                'href' => '/admin/super/organisations',
                'icon' => 'fa-solid fa-building',
            ],
        ];

        if ($request->user()) {

            if (! $request->user()->hasRole('Super Admin')) {
                return $standardNavItems;
            }

            return array_merge($standardNavItems, $superAdminNavItems);
        }

        return null;
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
                'services' => $request->user()->services,
            ],
            'services' => Service::all(),
            'slots' => [],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'mainNavItems' => $this->setNavItems($request),
        ];
    }
}
