<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class PageController extends Controller
{
    /**
     * Display the About Us page.
     */
    public function about()
    {
        return Inertia::render('Pages/About', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Display the Contact page.
     */
    public function contact()
    {
        return Inertia::render('Pages/Contact', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Display the Careers page.
     */
    public function careers()
    {
        return Inertia::render('Pages/Careers', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Display the Help Center / FAQ page.
     */
    public function help()
    {
        return Inertia::render('Pages/Help', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Display the Privacy Policy page.
     */
    public function privacy()
    {
        return Inertia::render('Pages/Privacy', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Display the Terms of Service page.
     */
    public function terms()
    {
        return Inertia::render('Pages/Terms', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Display the Blog listing page.
     */
    public function blog()
    {
        $blogs = Blog::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->through(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'featured_image' => $blog->featured_image ? asset('storage/' . $blog->featured_image) : null,
                    'author' => $blog->author,
                    'published_at' => $blog->published_at?->format('F d, Y'),
                    'category' => $blog->category,
                    'views' => $blog->views,
                ];
            });

        return Inertia::render('Pages/Blog', [
            'blogs' => $blogs,
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'tour_id' => 'nullable|exists:tour_packages,id',
        ]);

        // Determine inquiry type
        $type = $request->has('tour_id') ? 'tour' : 'general';

        // Create inquiry
        Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'type' => $type,
            'status' => 'new',
            'tour_package_id' => $validated['tour_id'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}

