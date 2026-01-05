<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\VisaRequirement;
use App\Services\SeoService;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Get the asset URL for a storage path.
     */
    private function getStorageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, '/storage/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }

    /**
     * Display the home page with real data.
     */
    public function index()
    {
        // Fetch featured tours (limit to 6, prioritize featured ones)
        $featuredTours = TourPackage::where('is_active', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($tour) {
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
                    'thumbnail' => $this->getStorageUrl($tour->thumbnail),
                    'image' => $this->getStorageUrl($tour->thumbnail),
                    'destination' => $tour->destination,
                ];
            });

        // Fetch active visa requirements (limit to 8)
        $visaServices = VisaRequirement::where('is_active', true)
            ->orderBy('country', 'asc')
            ->limit(8)
            ->get()
            ->map(function ($visa) {
                return [
                    'id' => $visa->id,
                    'country' => $visa->country,
                    'slug' => $visa->slug,
                    'description' => $visa->description,
                    'processing_time' => $visa->processing_time,
                    'visa_fee' => $visa->visa_fee,
                    'currency' => $visa->currency ?? 'BDT',
                ];
            });

        // Get unique countries and visa types from active visa requirements
        $visaCountries = VisaRequirement::where('is_active', true)
            ->select('country')
            ->distinct()
            ->orderBy('country', 'asc')
            ->pluck('country')
            ->toArray();

        $visaTypes = VisaRequirement::where('is_active', true)
            ->whereNotNull('visa_type')
            ->orderBy('visa_type', 'asc')
            ->get()
            ->pluck('visa_type')
            ->unique()
            ->values()
            ->toArray();

        $seoMeta = SeoService::defaultMeta();
        $organizationSchema = SeoService::organizationSchema();

        return Inertia::render('Welcome', [
            'featuredTours' => $featuredTours,
            'visaServices' => $visaServices,
            'visaCountries' => $visaCountries,
            'visaTypes' => $visaTypes,
            'seoMeta' => $seoMeta,
            'organizationSchema' => $organizationSchema,
        ]);
    }
}
