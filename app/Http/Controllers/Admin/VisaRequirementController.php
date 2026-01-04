<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisaRequirement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class VisaRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VisaRequirement::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('country', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $visas = $query->latest()->paginate(15);

        return Inertia::render('Admin/Visas/Index', [
            'visas' => $visas,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Visas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:255',
            'country_code' => 'nullable|string|max:3',
            'visa_type' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:visa_requirements,slug',
            'description' => 'nullable|string',
            'required_documents' => 'required|array|min:1',
            'required_documents.*' => 'required|string',
            'application_guidelines' => 'nullable|string',
            'processing_time' => 'nullable|string',
            'visa_fee' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'eligibility_criteria' => 'nullable|string',
            'important_notes' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['country']);
        }

        VisaRequirement::create($validated);

        return redirect()->route('admin.visas.index')
            ->with('success', 'Visa requirement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $visa = VisaRequirement::with('inquiries')->findOrFail($id);

        return Inertia::render('Admin/Visas/Show', [
            'visa' => $visa,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $visa = VisaRequirement::findOrFail($id);

        return Inertia::render('Admin/Visas/Edit', [
            'visa' => $visa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $visa = VisaRequirement::findOrFail($id);

        $validated = $request->validate([
            'country' => 'required|string|max:255',
            'country_code' => 'nullable|string|max:3',
            'visa_type' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:visa_requirements,slug,' . $id,
            'description' => 'nullable|string',
            'required_documents' => 'required|array|min:1',
            'required_documents.*' => 'required|string',
            'application_guidelines' => 'nullable|string',
            'processing_time' => 'nullable|string',
            'visa_fee' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'eligibility_criteria' => 'nullable|string',
            'important_notes' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['country']);
        }

        $visa->update($validated);

        return redirect()->route('admin.visas.index')
            ->with('success', 'Visa requirement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visa = VisaRequirement::findOrFail($id);
        $visa->delete();

        return redirect()->route('admin.visas.index')
            ->with('success', 'Visa requirement deleted successfully.');
    }
}
