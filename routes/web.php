<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganisationController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index',
        'logo' => asset('storage/images/logo.webp'),
    ])->name('dashboard');
});

Route::middleware(['role:Super Admin'])->group(function () {
    Route::get('admin/super/organisations', [OrganisationController::class, 'index'])
        ->name('admin.super.organisations');
});

require __DIR__.'/settings.php';
