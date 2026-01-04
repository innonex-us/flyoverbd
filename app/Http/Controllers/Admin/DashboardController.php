<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\TourPackage;
use App\Models\VisaRequirement;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'tours' => [
                'total' => TourPackage::count(),
                'active' => TourPackage::where('is_active', true)->count(),
                'featured' => TourPackage::where('is_featured', true)->count(),
            ],
            'visas' => [
                'total' => VisaRequirement::count(),
                'active' => VisaRequirement::where('is_active', true)->count(),
            ],
            'inquiries' => [
                'total' => Inquiry::count(),
                'new' => Inquiry::where('status', 'new')->count(),
                'in_progress' => Inquiry::where('status', 'in_progress')->count(),
            ],
            'bookings' => [
                'total' => Booking::count(),
                'pending' => Booking::where('booking_status', 'pending')->count(),
                'confirmed' => Booking::where('booking_status', 'confirmed')->count(),
                'revenue' => Booking::where('payment_status', 'paid')->sum('paid_amount'),
            ],
        ];

        $recentInquiries = Inquiry::with(['tour', 'visaRequirement'])
            ->latest()
            ->limit(5)
            ->get();

        $recentBookings = Booking::with('tour')
            ->latest()
            ->limit(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentInquiries' => $recentInquiries,
            'recentBookings' => $recentBookings,
        ]);
    }
}
