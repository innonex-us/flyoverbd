<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with('tour');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Filter by booking status
        if ($request->has('booking_status') && $request->booking_status !== 'all') {
            $query->where('booking_status', $request->booking_status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        $bookings = $query->latest()->paginate(15);

        return Inertia::render('Admin/Bookings/Index', [
            'bookings' => $bookings,
            'filters' => $request->only(['search', 'booking_status', 'payment_status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tours = TourPackage::where('is_active', true)->get();

        return Inertia::render('Admin/Bookings/Create', [
            'tours' => $tours,
        ]);
    }

    /**
     * Store a newly created resource in storage.
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
            'participants' => 'nullable|array',
            'travel_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        if (empty($validated['paid_amount'])) {
            $validated['paid_amount'] = 0;
        }

        if ($validated['booking_status'] === 'confirmed') {
            $validated['confirmed_at'] = now();
        }

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with(['tour', 'assignedUser'])->findOrFail($id);
        $users = User::all();

        return Inertia::render('Admin/Bookings/Show', [
            'booking' => $booking,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Booking::findOrFail($id);
        $tours = TourPackage::where('is_active', true)->get();
        $users = User::all();

        return Inertia::render('Admin/Bookings/Edit', [
            'booking' => $booking,
            'tours' => $tours,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_address' => 'nullable|string',
            'number_of_participants' => 'required|integer|min:1',
            'participants' => 'nullable|array',
            'travel_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        if (empty($validated['paid_amount'])) {
            $validated['paid_amount'] = 0;
        }

        // Handle status changes
        if ($validated['booking_status'] === 'confirmed' && $booking->booking_status !== 'confirmed') {
            $validated['confirmed_at'] = now();
        }

        if ($validated['booking_status'] === 'cancelled' && $booking->booking_status !== 'cancelled') {
            $validated['cancelled_at'] = now();
        }

        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $id)
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
