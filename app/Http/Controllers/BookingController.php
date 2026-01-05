<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Show the booking form for a specific tour.
     */
    public function create(Request $request, string $slug)
    {
        $tour = TourPackage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return Inertia::render('Bookings/Create', [
            'tour' => [
                'id' => $tour->id,
                'title' => $tour->title,
                'slug' => $tour->slug,
                'price' => (float) $tour->price,
                'currency' => $tour->currency ?? 'BDT',
                'max_participants' => $tour->max_participants,
                'min_participants' => $tour->min_participants ?? 1,
            ],
        ]);
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_address' => 'nullable|string',
            'number_of_participants' => 'required|integer|min:1',
            'travel_date' => 'nullable|date|after_or_equal:today',
            'special_requests' => 'nullable|string',
        ]);

        // Get the tour to calculate total amount
        $tour = TourPackage::findOrFail($validated['tour_id']);

        // Calculate total amount
        $totalAmount = $tour->price * $validated['number_of_participants'];

        // Check max participants
        if ($tour->max_participants && $validated['number_of_participants'] > $tour->max_participants) {
            return redirect()->back()
                ->withErrors(['number_of_participants' => "Maximum {$tour->max_participants} participants allowed for this tour."])
                ->withInput();
        }

        // Check min participants
        if ($tour->min_participants && $validated['number_of_participants'] < $tour->min_participants) {
            return redirect()->back()
                ->withErrors(['number_of_participants' => "Minimum {$tour->min_participants} participants required for this tour."])
                ->withInput();
        }

        // Create booking
        $booking = Booking::create([
            'tour_id' => $validated['tour_id'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'] ?? null,
            'number_of_participants' => $validated['number_of_participants'],
            'travel_date' => $validated['travel_date'] ?? null,
            'total_amount' => $totalAmount,
            'paid_amount' => 0,
            'currency' => $tour->currency ?? 'BDT',
            'payment_status' => 'pending',
            'booking_status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('bookings.success', $booking->booking_reference)
            ->with('success', 'Your booking has been submitted successfully!');
    }

    /**
     * Show booking success page.
     */
    public function success(string $reference)
    {
        $booking = Booking::where('booking_reference', $reference)
            ->with('tour')
            ->firstOrFail();

        return Inertia::render('Bookings/Success', [
            'booking' => [
                'booking_reference' => $booking->booking_reference,
                'customer_name' => $booking->customer_name,
                'customer_email' => $booking->customer_email,
                'tour_title' => $booking->tour->title,
                'number_of_participants' => $booking->number_of_participants,
                'total_amount' => (float) $booking->total_amount,
                'currency' => $booking->currency,
                'travel_date' => $booking->travel_date?->format('F d, Y'),
                'booking_status' => $booking->booking_status,
            ],
        ]);
    }
}
