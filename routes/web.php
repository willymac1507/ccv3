<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganisationController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index',
        'logo' => asset('storage/images/logo.webp'),
    ])->name('dashboard');
});

Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
});

Route::middleware(['auth', 'role:Client'])->group(function () {
    Route::get('organisations/search', [OrganisationController::class, 'search'])->name('organisations.search');
    Route::get('organisations/{organisation:id}/available-students', [OrganisationController::class, 'availableStudents'])->name('organisation.availableStudents');
    Route::get('students/{user:id}/appointments', [AppointmentController::class, 'index'])->name('students.appointments.index');
    Route::get('api/organisations/{organisation:id}/students/available', [OrganisationController::class, 'getAvailableStudents'])->name('api.students.available');
});

Route::middleware(['role:Super Admin'])->group(function () {
    Route::get('admin/super/organisations', [OrganisationController::class, 'index'])
        ->name('admin.super.organisation.index');
    Route::get('admin/super/organisation/{organisation:id}/show', [OrganisationController::class, 'show'])->name('admin.super.organisation.show');
});

require __DIR__ . '/settings.php';
