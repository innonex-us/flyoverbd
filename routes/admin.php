<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\TourPackageController;
use App\Http\Controllers\Admin\VisaRequirementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('cp')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tour Packages
    Route::resource('tours', TourPackageController::class);

    // Visa Requirements
    Route::resource('visas', VisaRequirementController::class);

    // Inquiries
    Route::resource('inquiries', InquiryController::class);

    // Bookings
    Route::resource('bookings', BookingController::class);

    // Blogs
    Route::resource('blogs', BlogController::class);
});

