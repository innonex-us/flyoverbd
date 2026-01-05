<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\TourPackage;
use App\Models\VisaRequirement;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap.
     */
    public function index(): Response
    {
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $now = now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $xml .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $xml .= ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9';
        $xml .= ' http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'."\n";

        // Homepage
        $xml .= $this->urlElement($siteUrl, '1.0', 'daily', $now);

        // Static pages
        $staticPages = [
            '/about' => '0.8',
            '/contact' => '0.8',
            '/tours' => '0.9',
            '/visas' => '0.9',
            '/blog' => '0.8',
            '/careers' => '0.6',
            '/help' => '0.7',
            '/privacy' => '0.5',
            '/terms' => '0.5',
        ];

        foreach ($staticPages as $path => $priority) {
            $xml .= $this->urlElement($siteUrl.$path, $priority, 'weekly', $now);
        }

        // Tour packages
        $tours = TourPackage::where('is_active', true)->get();
        foreach ($tours as $tour) {
            $lastmod = $tour->updated_at ? $tour->updated_at->toAtomString() : $now;
            $xml .= $this->urlElement(
                $siteUrl.'/tours/'.$tour->slug,
                '0.9',
                'weekly',
                $lastmod
            );
        }

        // Visa requirements
        $visas = VisaRequirement::where('is_active', true)->get();
        foreach ($visas as $visa) {
            $lastmod = $visa->updated_at ? $visa->updated_at->toAtomString() : $now;
            $xml .= $this->urlElement(
                $siteUrl.'/visas/'.$visa->slug,
                '0.8',
                'monthly',
                $lastmod
            );
        }

        // Blog posts
        $blogs = Blog::where('is_published', true)->get();
        foreach ($blogs as $blog) {
            $lastmod = $blog->updated_at ? $blog->updated_at->toAtomString() : $now;
            $xml .= $this->urlElement(
                $siteUrl.'/blog/'.$blog->slug,
                '0.7',
                'weekly',
                $lastmod
            );
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Generate a URL element for sitemap.
     */
    private function urlElement(string $url, string $priority, string $changefreq, string $lastmod): string
    {
        $xml = '  <url>'."\n";
        $xml .= '    <loc>'.htmlspecialchars($url, ENT_XML1, 'UTF-8').'</loc>'."\n";
        $xml .= '    <lastmod>'.$lastmod.'</lastmod>'."\n";
        $xml .= '    <changefreq>'.$changefreq.'</changefreq>'."\n";
        $xml .= '    <priority>'.$priority.'</priority>'."\n";
        $xml .= '  </url>'."\n";

        return $xml;
    }
}
