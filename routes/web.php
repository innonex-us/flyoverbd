<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\VisaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Tour Routes
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');

// Public Booking Routes
Route::get('/tours/{slug}/book', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/success/{reference}', [App\Http\Controllers\BookingController::class, 'success'])->name('bookings.success');

// Public Visa Routes
Route::get('/visas', [VisaController::class, 'index'])->name('visas.index');
Route::get('/visas/{slug}', [VisaController::class, 'show'])->name('visas.show');

// Public Pages
Route::get('/about', [App\Http\Controllers\PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [App\Http\Controllers\PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact/submit', [App\Http\Controllers\PageController::class, 'submitContact'])->name('pages.contact.submit');
Route::get('/careers', [App\Http\Controllers\PageController::class, 'careers'])->name('pages.careers');
Route::get('/help', [App\Http\Controllers\PageController::class, 'help'])->name('pages.help');
Route::get('/privacy', [App\Http\Controllers\PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/terms', [App\Http\Controllers\PageController::class, 'terms'])->name('pages.terms');
Route::get('/blog', [App\Http\Controllers\PageController::class, 'blog'])->name('pages.blog');
Route::get('/blog/{slug}', [App\Http\Controllers\PageController::class, 'blogShow'])->name('pages.blog.show');

// SEO Routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

Route::get('dashboard', function () {
    // Redirect to admin dashboard
    return redirect('/cp/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/admin.php';
require __DIR__.'/settings.php';
