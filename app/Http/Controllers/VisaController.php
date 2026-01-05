<?php

namespace App\Http\Controllers;

use App\Models\VisaRequirement;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class VisaController extends Controller
{
    /**
     * Display a listing of visa requirements.
     */
    public function index(Request $request)
    {
        $query = VisaRequirement::where('is_active', true);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('country', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by visa type
        if ($request->has('visa_type') && $request->visa_type) {
            $query->where('visa_type', $request->visa_type);
        }

        $visas = $query->orderBy('country', 'asc')
            ->paginate(12)
            ->through(function ($visa) {
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

        $seoMeta = [
            'title' => 'Visa Assistance Services - Flyover BD',
            'description' => 'Get professional visa assistance for countries around the world. Expert guidance and support for your visa applications.',
            'canonical' => config('app.url', 'https://flyoverbd.com').'/visas',
        ];

        return Inertia::render('Visas/Index', [
            'visas' => $visas,
            'filters' => $request->only(['search']),
            'canRegister' => Features::enabled(Features::registration()),
            'seoMeta' => $seoMeta,
        ]);
    }

    /**
     * Display the specified visa requirement.
     */
    public function show(string $slug)
    {
        $visa = VisaRequirement::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related visas (other active visas, excluding current)
        $relatedVisas = VisaRequirement::where('id', '!=', $visa->id)
            ->where('is_active', true)
            ->orderBy('country', 'asc')
            ->limit(4)
            ->get()
            ->map(function ($relatedVisa) {
                return [
                    'id' => $relatedVisa->id,
                    'country' => $relatedVisa->country,
                    'slug' => $relatedVisa->slug,
                    'description' => $relatedVisa->description,
                    'visa_fee' => $relatedVisa->visa_fee,
                    'currency' => $relatedVisa->currency ?? 'BDT',
                ];
            });

        $visaData = [
            'id' => $visa->id,
            'country' => $visa->country,
            'country_code' => $visa->country_code,
            'slug' => $visa->slug,
            'description' => $visa->description,
            'required_documents' => $visa->required_documents ?? [],
            'application_guidelines' => $visa->application_guidelines,
            'processing_time' => $visa->processing_time,
            'visa_fee' => $visa->visa_fee,
            'currency' => $visa->currency ?? 'BDT',
            'eligibility_criteria' => $visa->eligibility_criteria,
            'important_notes' => $visa->important_notes,
            'meta_title' => $visa->meta_title,
            'meta_description' => $visa->meta_description,
        ];

        $seoMeta = SeoService::visaMeta($visaData);
        $visaSchema = SeoService::visaSchema($visaData);
        $breadcrumbs = [
            ['title' => 'Home', 'href' => '/'],
            ['title' => 'Visas', 'href' => '/visas'],
            ['title' => $visaData['country'].' Visa', 'href' => '#'],
        ];

        return Inertia::render('Visas/Show', [
            'visa' => $visaData,
            'relatedVisas' => $relatedVisas,
            'canRegister' => Features::enabled(Features::registration()),
            'seoMeta' => $seoMeta,
            'visaSchema' => $visaSchema,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
