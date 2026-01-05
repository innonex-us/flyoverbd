<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Inquiry;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Display the About Us page.
     */
    public function about()
    {
        $seoMeta = [
            'title' => 'About Us - Flyover BD',
            'description' => 'Learn about Flyover BD - Your trusted partner for visa assistance and tour management services in Bangladesh.',
            'canonical' => config('app.url', 'https://flyoverbd.com').'/about',
        ];

        return Inertia::render('Pages/About', [
            'seoMeta' => $seoMeta,
        ]);
    }

    /**
     * Display the Contact page.
     */
    public function contact()
    {
        $seoMeta = [
            'title' => 'Contact Us - Flyover BD',
            'description' => 'Get in touch with Flyover BD for visa assistance and tour inquiries. We are here to help you with your travel needs.',
            'canonical' => config('app.url', 'https://flyoverbd.com').'/contact',
        ];

        return Inertia::render('Pages/Contact', [
            'seoMeta' => $seoMeta,
        ]);
    }

    /**
     * Display the Help Center / FAQ page.
     */
    public function help()
    {
        return Inertia::render('Pages/Help', []);
    }

    /**
     * Display the Privacy Policy page.
     */
    public function privacy()
    {
        return Inertia::render('Pages/Privacy', []);
    }

    /**
     * Display the Terms of Service page.
     */
    public function terms()
    {
        return Inertia::render('Pages/Terms', []);
    }

    /**
     * Display the Blog listing page.
     */
    public function blog()
    {
        $blogs = Blog::query()
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->through(function ($blog) {
                $featuredImage = null;
                if ($blog->featured_image) {
                    $featuredImage = str_starts_with($blog->featured_image, '/storage/')
                        ? asset($blog->featured_image)
                        : asset('storage/'.$blog->featured_image);
                }

                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'featured_image' => $featuredImage,
                    'author' => $blog->author,
                    'published_at' => $blog->published_at?->format('F d, Y'),
                    'category' => $blog->category,
                    'views' => $blog->views,
                ];
            });

        $seoMeta = [
            'title' => 'Travel Blog - Flyover BD',
            'description' => 'Read travel tips, visa guides, and destination insights from Flyover BD.',
            'canonical' => config('app.url', 'https://flyoverbd.com').'/blog',
        ];

        return Inertia::render('Pages/Blog', [
            'blogs' => $blogs,
            'seoMeta' => $seoMeta,
        ]);
    }

    /**
     * Display a single blog post.
     */
    public function blogShow(string $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Increment views
        $blog->increment('views');

        // Get related blogs (same category, excluding current)
        $relatedBlogs = Blog::where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->limit(3)
            ->get()
            ->map(function ($relatedBlog) {
                return [
                    'id' => $relatedBlog->id,
                    'title' => $relatedBlog->title,
                    'slug' => $relatedBlog->slug,
                    'excerpt' => $relatedBlog->excerpt,
                    'featured_image' => $relatedBlog->featured_image
                        ? (str_starts_with($relatedBlog->featured_image, '/storage/')
                            ? asset($relatedBlog->featured_image)
                            : asset('storage/'.$relatedBlog->featured_image))
                        : null,
                    'published_at' => $relatedBlog->published_at?->format('F d, Y'),
                ];
            });

        $blogData = [
            'id' => $blog->id,
            'title' => $blog->title,
            'slug' => $blog->slug,
            'excerpt' => $blog->excerpt,
            'content' => $blog->content,
            'featured_image' => $blog->featured_image
                ? (str_starts_with($blog->featured_image, '/storage/')
                    ? asset($blog->featured_image)
                    : asset('storage/'.$blog->featured_image))
                : null,
            'images' => $blog->images ? array_map(function ($image) {
                return str_starts_with($image, '/storage/')
                    ? asset($image)
                    : asset('storage/'.$image);
            }, $blog->images) : [],
            'author' => $blog->author,
            'published_at' => $blog->published_at?->toIso8601String(),
            'published_at_formatted' => $blog->published_at?->format('F d, Y'),
            'category' => $blog->category,
            'tags' => $blog->tags ?? [],
            'views' => $blog->views,
            'meta_title' => $blog->meta_title,
            'meta_description' => $blog->meta_description,
            'meta_keywords' => $blog->meta_keywords,
        ];

        $seoMeta = SeoService::blogMeta($blogData);
        $articleSchema = SeoService::articleSchema($blogData);
        $breadcrumbs = [
            ['title' => 'Home', 'href' => '/'],
            ['title' => 'Blog', 'href' => '/blog'],
            ['title' => $blogData['title'], 'href' => '#'],
        ];

        return Inertia::render('Pages/BlogShow', [
            'blog' => $blogData,
            'relatedBlogs' => $relatedBlogs,
            'seoMeta' => $seoMeta,
            'articleSchema' => $articleSchema,
            'breadcrumbs' => $breadcrumbs,
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
            'tour_id' => 'nullable|exists:tours,id',
            'visa_id' => 'nullable|exists:visa_requirements,id',
        ]);

        // Determine inquiry type
        $type = $request->has('tour_id') ? 'tour' : ($request->has('visa_id') ? 'visa' : 'general');

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
            'visa_requirement_id' => $validated['visa_id'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}
