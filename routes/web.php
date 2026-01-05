<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\VisaController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/help', [App\Http\Controllers\PageController::class, 'help'])->name('pages.help');
Route::get('/privacy', [App\Http\Controllers\PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/terms', [App\Http\Controllers\PageController::class, 'terms'])->name('pages.terms');
Route::get('/blog', [App\Http\Controllers\PageController::class, 'blog'])->name('pages.blog');
Route::get('/blog/{slug}', [App\Http\Controllers\PageController::class, 'blogShow'])->name('pages.blog.show');

// Block registration (registration is disabled)
Route::match(['get', 'post'], '/access/register', function () {
    abort(404, 'Registration is not available.');
})->name('register');

// SEO Routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Setup Route
Route::get('/setup.php', function () {
    $output = [];
    $output[] = '<!DOCTYPE html>';
    $output[] = '<html lang="en">';
    $output[] = '<head>';
    $output[] = '<meta charset="UTF-8">';
    $output[] = '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $output[] = '<title>Setup - Flyover BD</title>';
    $output[] = '<style>';
    $output[] = 'body { font-family: monospace; padding: 20px; background: #1a1a1a; color: #00ff00; }';
    $output[] = '.success { color: #00ff00; }';
    $output[] = '.error { color: #ff0000; }';
    $output[] = '.info { color: #ffff00; }';
    $output[] = 'pre { background: #000; padding: 15px; border-radius: 5px; }';
    $output[] = '</style>';
    $output[] = '</head>';
    $output[] = '<body>';
    $output[] = '<h1>Setup Script</h1>';
    $output[] = '<pre>';

    try {
        $output[] = 'Starting setup...'."\n\n";

        // Run migrations
        $output[] = 'Running database migrations...'."\n";
        Artisan::call('migrate', ['--force' => true]);
        $output[] = '<span class="success">✓ Migrations completed successfully.</span>'."\n\n";

        // Create storage link
        $output[] = 'Creating storage link...'."\n";
        try {
            Artisan::call('storage:link');
            $output[] = '<span class="success">✓ Storage link created successfully.</span>'."\n\n";
        } catch (Exception $e) {
            if (str_contains($e->getMessage(), 'already exists')) {
                $output[] = '<span class="info">ℹ Storage link already exists.</span>'."\n\n";
            } else {
                throw $e;
            }
        }

        $output[] = '<span class="success">Setup completed successfully!</span>'."\n";
    } catch (Exception $e) {
        $output[] = '<span class="error">✗ Error: '.htmlspecialchars($e->getMessage()).'</span>'."\n";
    }

    $output[] = '</pre>';
    $output[] = '</body>';
    $output[] = '</html>';

    return implode("\n", $output);
})->name('setup');

require __DIR__.'/admin.php';
require __DIR__.'/settings.php';
