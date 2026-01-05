<?php

namespace App\Services;

class SeoService
{
    /**
     * Generate default SEO meta data for the application.
     */
    public static function defaultMeta(): array
    {
        $siteName = config('app.name', 'Flyover BD');
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $defaultDescription = 'Professional visa assistance and tour management services in Bangladesh. Explore amazing destinations with Flyover BD.';

        return [
            'title' => $siteName.' - Visa & Tour Management',
            'description' => $defaultDescription,
            'keywords' => 'visa assistance, tour packages, travel agency, Bangladesh, visa services, tour management',
            'og_title' => $siteName.' - Visa & Tour Management',
            'og_description' => $defaultDescription,
            'og_type' => 'website',
            'og_url' => $siteUrl,
            'og_image' => asset('logo.png'),
            'twitter_card' => 'summary_large_image',
            'canonical' => $siteUrl,
        ];
    }

    /**
     * Generate SEO meta data for a tour package.
     */
    public static function tourMeta($tour): array
    {
        $siteName = config('app.name', 'Flyover BD');
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $tourUrl = $siteUrl.'/tours/'.$tour['slug'];
        $title = $tour['meta_title'] ?? $tour['title'].' - Tour Package | '.$siteName;
        $description = $tour['meta_description'] ?? substr(strip_tags($tour['description'] ?? ''), 0, 160);
        $image = $tour['thumbnail'] ?? $tour['image'] ?? asset('logo.png');

        return [
            'title' => $title,
            'description' => $description ?: 'Explore this amazing tour package with Flyover BD.',
            'keywords' => 'tour package, '.$tour['destination'].', travel, '.$siteName,
            'og_title' => $title,
            'og_description' => $description ?: 'Explore this amazing tour package with Flyover BD.',
            'og_type' => 'product',
            'og_url' => $tourUrl,
            'og_image' => $image,
            'twitter_card' => 'summary_large_image',
            'canonical' => $tourUrl,
        ];
    }

    /**
     * Generate SEO meta data for a visa requirement.
     */
    public static function visaMeta($visa): array
    {
        $siteName = config('app.name', 'Flyover BD');
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $visaUrl = $siteUrl.'/visas/'.$visa['slug'];
        $title = $visa['meta_title'] ?? $visa['country'].' Visa Assistance | '.$siteName;
        $description = $visa['meta_description'] ?? substr(strip_tags($visa['description'] ?? ''), 0, 160);

        return [
            'title' => $title,
            'description' => $description ?: 'Get professional visa assistance for '.$visa['country'].' with Flyover BD.',
            'keywords' => $visa['country'].' visa, visa assistance, visa services, '.$siteName,
            'og_title' => $title,
            'og_description' => $description ?: 'Get professional visa assistance for '.$visa['country'].' with Flyover BD.',
            'og_type' => 'service',
            'og_url' => $visaUrl,
            'og_image' => asset('logo.png'),
            'twitter_card' => 'summary_large_image',
            'canonical' => $visaUrl,
        ];
    }

    /**
     * Generate SEO meta data for a blog post.
     */
    public static function blogMeta($blog): array
    {
        $siteName = config('app.name', 'Flyover BD');
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $blogUrl = $siteUrl.'/blog/'.$blog['slug'];
        $title = $blog['meta_title'] ?? $blog['title'].' | '.$siteName;
        $description = $blog['meta_description'] ?? $blog['excerpt'] ?? substr(strip_tags($blog['content'] ?? ''), 0, 160);
        $image = $blog['featured_image'] ?? asset('logo.png');

        return [
            'title' => $title,
            'description' => $description ?: 'Read this article on '.$siteName,
            'keywords' => $blog['meta_keywords'] ?? 'travel blog, '.$siteName,
            'og_title' => $title,
            'og_description' => $description ?: 'Read this article on '.$siteName,
            'og_type' => 'article',
            'og_url' => $blogUrl,
            'og_image' => $image,
            'twitter_card' => 'summary_large_image',
            'canonical' => $blogUrl,
            'article_published_time' => $blog['published_at'] ?? null,
            'article_author' => $blog['author'] ?? $siteName,
        ];
    }

    /**
     * Generate Organization schema (JSON-LD).
     */
    public static function organizationSchema(): array
    {
        $siteName = config('app.name', 'Flyover BD');
        $siteUrl = config('app.url', 'https://flyoverbd.com');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'TravelAgency',
            'name' => $siteName,
            'url' => $siteUrl,
            'logo' => $siteUrl.'/logo.png',
            'description' => 'Professional visa assistance and tour management services in Bangladesh.',
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'BD',
            ],
            'sameAs' => [
                // Add social media links here when available
            ],
        ];
    }

    /**
     * Generate Tour/TouristTrip schema (JSON-LD).
     */
    public static function tourSchema($tour): array
    {
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $tourUrl = $siteUrl.'/tours/'.$tour['slug'];
        $image = $tour['thumbnail'] ?? $tour['image'] ?? $siteUrl.'/logo.png';

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TouristTrip',
            'name' => $tour['title'],
            'description' => strip_tags($tour['description'] ?? ''),
            'url' => $tourUrl,
            'image' => $image,
            'offers' => [
                '@type' => 'Offer',
                'price' => $tour['price'],
                'priceCurrency' => $tour['currency'] ?? 'BDT',
                'availability' => 'https://schema.org/InStock',
                'url' => $tourUrl,
            ],
        ];

        if (isset($tour['destination'])) {
            $schema['destination'] = [
                '@type' => 'Place',
                'name' => $tour['destination'],
            ];
        }

        if (isset($tour['duration_days'])) {
            $schema['duration'] = 'P'.$tour['duration_days'].'D';
        }

        if (isset($tour['start_date'])) {
            $schema['startDate'] = $tour['start_date'];
        }

        if (isset($tour['end_date'])) {
            $schema['endDate'] = $tour['end_date'];
        }

        return $schema;
    }

    /**
     * Generate Service schema for visa (JSON-LD).
     */
    public static function visaSchema($visa): array
    {
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $visaUrl = $siteUrl.'/visas/'.$visa['slug'];

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $visa['country'].' Visa Assistance',
            'description' => strip_tags($visa['description'] ?? ''),
            'url' => $visaUrl,
            'provider' => [
                '@type' => 'TravelAgency',
                'name' => config('app.name', 'Flyover BD'),
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => $visa['country'],
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $visa['visa_fee'] ?? 0,
                'priceCurrency' => $visa['currency'] ?? 'BDT',
            ],
        ];
    }

    /**
     * Generate Article schema for blog (JSON-LD).
     */
    public static function articleSchema($blog): array
    {
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $blogUrl = $siteUrl.'/blog/'.$blog['slug'];
        $image = $blog['featured_image'] ?? $siteUrl.'/logo.png';

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $blog['title'],
            'description' => strip_tags($blog['excerpt'] ?? $blog['content'] ?? ''),
            'url' => $blogUrl,
            'image' => $image,
            'author' => [
                '@type' => 'Organization',
                'name' => $blog['author'] ?? config('app.name', 'Flyover BD'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name', 'Flyover BD'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $siteUrl.'/logo.png',
                ],
            ],
        ];

        if (isset($blog['published_at'])) {
            $schema['datePublished'] = $blog['published_at'];
        }

        return $schema;
    }

    /**
     * Generate BreadcrumbList schema (JSON-LD).
     */
    public static function breadcrumbSchema($items): array
    {
        $siteUrl = config('app.url', 'https://flyoverbd.com');
        $breadcrumbItems = [];

        foreach ($items as $index => $item) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['title'],
                'item' => isset($item['href']) && $item['href'] !== '#' ? $siteUrl.$item['href'] : null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbItems,
        ];
    }
}
