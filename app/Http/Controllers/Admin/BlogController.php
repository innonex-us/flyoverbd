<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::with('authorUser');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $blogs = $query->latest()->paginate(15);

        return Inertia::render('Admin/Blogs/Index', [
            'blogs' => $blogs,
            'filters' => $request->only(['search', 'status', 'category']),
            'categories' => Blog::whereNotNull('category')->distinct()->pluck('category'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Blogs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (empty($validated['author']) && auth()->check()) {
            $validated['author'] = auth()->user()->name;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('blogs/featured', 'public');
            $validated['featured_image'] = Storage::url($featuredImagePath);
        } else {
            unset($validated['featured_image']);
        }

        // Handle additional images upload
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('blogs/images', 'public');
                $uploadedImages[] = Storage::url($imagePath);
            }
            $validated['images'] = $uploadedImages;
        } else {
            unset($validated['images']);
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::with('authorUser')->findOrFail($id);

        return Inertia::render('Admin/Blogs/Show', [
            'blog' => $blog,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);

        return Inertia::render('Admin/Blogs/Edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'remove_featured_image' => 'nullable|boolean',
            'remove_images' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image upload or removal
        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($blog->featured_image) {
                $oldPath = str_replace('/storage/', '', $blog->featured_image);
                Storage::disk('public')->delete($oldPath);
            }
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('blogs/featured', 'public');
            $validated['featured_image'] = Storage::url($featuredImagePath);
        } elseif ($request->boolean('remove_featured_image') && $blog->featured_image) {
            $oldPath = str_replace('/storage/', '', $blog->featured_image);
            Storage::disk('public')->delete($oldPath);
            $validated['featured_image'] = null;
        } else {
            unset($validated['featured_image']);
        }

        // Handle additional images upload
        $currentImages = $blog->images ?? [];
        $uploadedImages = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('blogs/images', 'public');
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

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        // Delete featured image
        if ($blog->featured_image) {
            $oldPath = str_replace('/storage/', '', $blog->featured_image);
            Storage::disk('public')->delete($oldPath);
        }

        // Delete additional images
        if ($blog->images) {
            foreach ($blog->images as $image) {
                $oldPath = str_replace('/storage/', '', $image);
                Storage::disk('public')->delete($oldPath);
            }
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
