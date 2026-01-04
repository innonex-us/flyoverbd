<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class TourPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TourPackage::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        $tours = $query->latest()->paginate(15);

        return Inertia::render('Admin/Tours/Index', [
            'tours' => $tours,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Tours/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tours,slug',
            'description' => 'required|string',
            'itinerary' => 'nullable|string',
            'highlights' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'duration_days' => 'required|integer|min:1',
            'destination' => 'nullable|string|max:255',
            'departure_location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'min_participants' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = $thumbnail->store('tours/thumbnails', 'public');
            $validated['thumbnail'] = Storage::url($thumbnailPath);
        } else {
            unset($validated['thumbnail']);
        }

        // Handle images upload
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('tours/images', 'public');
                $uploadedImages[] = Storage::url($imagePath);
            }
            $validated['images'] = $uploadedImages;
        } else {
            unset($validated['images']);
        }

        TourPackage::create($validated);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tour = TourPackage::with(['inquiries', 'bookings'])->findOrFail($id);

        return Inertia::render('Admin/Tours/Show', [
            'tour' => $tour,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tour = TourPackage::findOrFail($id);

        return Inertia::render('Admin/Tours/Edit', [
            'tour' => $tour,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tour = TourPackage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tours,slug,' . $id,
            'description' => 'required|string',
            'itinerary' => 'nullable|string',
            'highlights' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'duration_days' => 'required|integer|min:1',
            'destination' => 'nullable|string|max:255',
            'departure_location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'min_participants' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'remove_thumbnail' => 'nullable|boolean',
            'remove_images' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle thumbnail upload or removal
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($tour->thumbnail) {
                $oldPath = str_replace('/storage/', '', $tour->thumbnail);
                Storage::disk('public')->delete($oldPath);
            }
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = $thumbnail->store('tours/thumbnails', 'public');
            $validated['thumbnail'] = Storage::url($thumbnailPath);
        } elseif ($request->boolean('remove_thumbnail') && $tour->thumbnail) {
            $oldPath = str_replace('/storage/', '', $tour->thumbnail);
            Storage::disk('public')->delete($oldPath);
            $validated['thumbnail'] = null;
        } else {
            unset($validated['thumbnail']);
        }

        // Handle images upload
        $currentImages = $tour->images ?? [];
        $uploadedImages = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('tours/images', 'public');
                $uploadedImages[] = Storage::url($imagePath);
            }
        }

        // Remove images that are marked for removal
        $imagesToRemove = $request->input('remove_images', []);
        $currentImages = array_filter($currentImages, function($image) use ($imagesToRemove) {
            return !in_array($image, $imagesToRemove);
        });

        // Delete removed images from storage
        foreach ($imagesToRemove as $imageToRemove) {
            $oldPath = str_replace('/storage/', '', $imageToRemove);
            Storage::disk('public')->delete($oldPath);
        }

        // Merge current images with newly uploaded ones
        $validated['images'] = array_merge($currentImages, $uploadedImages);
        if (empty($validated['images'])) {
            $validated['images'] = null;
        }

        $tour->update($validated);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = TourPackage::findOrFail($id);

        // Delete thumbnail
        if ($tour->thumbnail) {
            $oldPath = str_replace('/storage/', '', $tour->thumbnail);
            Storage::disk('public')->delete($oldPath);
        }

        // Delete images
        if ($tour->images) {
            foreach ($tour->images as $image) {
                $oldPath = str_replace('/storage/', '', $image);
                Storage::disk('public')->delete($oldPath);
            }
        }

        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour package deleted successfully.');
    }
}
