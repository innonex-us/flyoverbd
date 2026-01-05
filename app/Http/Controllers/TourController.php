<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class TourController extends Controller
{
    /**
     * Display a listing of tours.
     */
    public function index(Request $request)
    {
        $query = TourPackage::where('is_active', true);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        // Filter by destination (country name)
        if ($request->has('destination')) {
            $query->where('destination', 'like', "%{$request->destination}%");
        }

        // Filter by start date
        if ($request->has('start_date')) {
            $query->where(function ($q) use ($request) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $request->start_date);
            });
        }

        // Filter by end date
        if ($request->has('end_date')) {
            $query->where(function ($q) use ($request) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $request->end_date);
            });
        }

        // Filter by participants (show tours that can accommodate the requested number)
        // If tour has max_participants, it must be >= requested
        // We show tours even if min_participants > requested (user can book for minimum)
        if ($request->has('participants') && $request->participants) {
            $participants = (int) $request->participants;
            $query->where(function ($q) use ($participants) {
                $q->whereNull('max_participants')
                    ->orWhere('max_participants', '>=', $participants);
            });
        }

        $tours = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->through(function ($tour) {
                return [
                    'id' => $tour->id,
                    'title' => $tour->title,
                    'slug' => $tour->slug,
                    'description' => $tour->description,
                    'price' => (float) $tour->price,
                    'currency' => $tour->currency ?? 'BDT',
                    'duration' => $tour->duration_days ? $tour->duration_days.' Days' : 'N/A',
                    'duration_days' => $tour->duration_days,
                    'featured' => $tour->is_featured,
                    'thumbnail' => $tour->thumbnail ? asset('storage/'.$tour->thumbnail) : null,
                    'destination' => $tour->destination,
                ];
            });

        return Inertia::render('Tours/Index', [
            'tours' => $tours,
            'filters' => $request->only(['search', 'destination', 'start_date', 'end_date', 'participants']),
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Display the specified tour.
     */
    public function show(string $slug)
    {
        $tour = TourPackage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related tours (same destination, excluding current)
        $relatedTours = TourPackage::where('destination', $tour->destination)
            ->where('id', '!=', $tour->id)
            ->where('is_active', true)
            ->limit(3)
            ->get()
            ->map(function ($relatedTour) {
                return [
                    'id' => $relatedTour->id,
                    'title' => $relatedTour->title,
                    'slug' => $relatedTour->slug,
                    'price' => (float) $relatedTour->price,
                    'currency' => $relatedTour->currency ?? 'BDT',
                    'duration' => $relatedTour->duration_days ? $relatedTour->duration_days.' Days' : 'N/A',
                    'thumbnail' => $relatedTour->thumbnail ? asset('storage/'.$relatedTour->thumbnail) : null,
                ];
            });

        $tourData = [
            'id' => $tour->id,
            'title' => $tour->title,
            'slug' => $tour->slug,
            'description' => $tour->description,
            'itinerary' => $tour->itinerary,
            'highlights' => $tour->highlights,
            'price' => (float) $tour->price,
            'currency' => $tour->currency ?? 'BDT',
            'duration_days' => $tour->duration_days,
            'duration' => $tour->duration_days ? $tour->duration_days.' Days' : 'N/A',
            'destination' => $tour->destination,
            'departure_location' => $tour->departure_location,
            'start_date' => $tour->start_date?->format('Y-m-d'),
            'end_date' => $tour->end_date?->format('Y-m-d'),
            'max_participants' => $tour->max_participants,
            'min_participants' => $tour->min_participants,
            'featured' => $tour->is_featured,
            'thumbnail' => $tour->thumbnail ? asset('storage/'.$tour->thumbnail) : null,
            'images' => $tour->images ? array_map(fn ($img) => asset('storage/'.$img), $tour->images) : [],
            'included' => $tour->included,
            'excluded' => $tour->excluded,
            'terms_conditions' => $tour->terms_conditions,
            'meta_title' => $tour->meta_title,
            'meta_description' => $tour->meta_description,
        ];

        return Inertia::render('Tours/Show', [
            'tour' => $tourData,
            'relatedTours' => $relatedTours,
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }
}
