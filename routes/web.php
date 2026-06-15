<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard', [
        'logo' => asset('storage/images/logo.webp'),
    ])->name('dashboard');
});

require __DIR__.'/settings.php';
