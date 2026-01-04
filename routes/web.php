<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\VisaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Tour Routes
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');

// Public Visa Routes
Route::get('/visas', [VisaController::class, 'index'])->name('visas.index');
Route::get('/visas/{slug}', [VisaController::class, 'show'])->name('visas.show');

Route::get('dashboard', function () {
    // Redirect to admin dashboard
    return redirect('/cp/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/admin.php';
require __DIR__.'/settings.php';
