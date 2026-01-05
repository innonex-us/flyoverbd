<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import SeoMeta from '@/components/SeoMeta.vue';
import { Card, CardContent } from '@/components/ui/card';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { Calendar, User, ArrowLeft, Share2, Tag, Eye } from 'lucide-vue-next';

interface Blog {
    id: number;
    title: string;
    slug: string;
    excerpt?: string | null;
    content: string;
    featured_image?: string | null;
    images: string[];
    author?: string | null;
    published_at?: string | null;
    published_at_formatted?: string | null;
    category?: string | null;
    tags: string[];
    views: number;
    meta_title?: string | null;
    meta_description?: string | null;
    meta_keywords?: string | null;
}

interface RelatedBlog {
    id: number;
    title: string;
    slug: string;
    excerpt?: string | null;
    featured_image?: string | null;
    published_at?: string | null;
}

interface Props {
    blog: Blog;
    relatedBlogs: RelatedBlog[];
    seoMeta?: Record<string, any>;
    articleSchema?: Record<string, any>;
    breadcrumbs?: Array<{ title: string; href?: string }>;
}

const props = withDefaults(defineProps<Props>(), {
});

const handleShare = () => {
    if (navigator.share) {
        navigator.share({
            title: props.blog.title,
            text: props.blog.excerpt || props.blog.content?.substring(0, 160) || '',
            url: window.location.href,
        }).catch(() => {
            // User cancelled or error occurred
        });
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copied to clipboard!');
        });
    }
};
</script>

<template>
    <SeoMeta
        :title="seoMeta?.title"
        :description="seoMeta?.description"
        :keywords="seoMeta?.keywords"
        :og-title="seoMeta?.og_title"
        :og-description="seoMeta?.og_description"
        :og-type="seoMeta?.og_type"
        :og-url="seoMeta?.og_url"
        :og-image="seoMeta?.og_image"
        :canonical="seoMeta?.canonical"
        :article-published-time="seoMeta?.article_published_time"
        :article-author="seoMeta?.article_author"
        :schema="articleSchema"
        :breadcrumbs="breadcrumbs"
    />

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation />
        
        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <Link href="/blog" class="mb-6 inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
                <ArrowLeft class="mr-2 h-4 w-4" />
                Back to Blog
            </Link>

            <article class="space-y-8">
                <!-- Header -->
                <div>
                    <div v-if="blog.category" class="mb-4">
                        <span class="rounded-full bg-red-100 px-4 py-1 text-sm font-semibold text-red-600">
                            {{ blog.category }}
                        </span>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                        {{ blog.title }}
                    </h1>
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                        <span v-if="blog.author" class="flex items-center">
                            <User class="mr-2 h-4 w-4" />
                            {{ blog.author }}
                        </span>
                        <span v-if="blog.published_at_formatted" class="flex items-center">
                            <Calendar class="mr-2 h-4 w-4" />
                            {{ blog.published_at_formatted }}
                        </span>
                        <span class="flex items-center">
                            <Eye class="mr-2 h-4 w-4" />
                            {{ blog.views }} views
                        </span>
                        <button
                            @click="handleShare"
                            class="flex items-center text-gray-600 hover:text-red-600 transition-colors"
                            title="Share"
                        >
                            <Share2 class="mr-2 h-4 w-4" />
                            Share
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <div v-if="blog.featured_image" class="aspect-video overflow-hidden rounded-2xl bg-gray-200">
                    <img 
                        :src="blog.featured_image" 
                        :alt="blog.title"
                        class="h-full w-full object-cover"
                    />
                </div>

                <!-- Content -->
                <Card class="bg-white text-gray-900">
                    <CardContent class="p-8">
                        <div v-if="blog.excerpt" class="mb-6 text-xl font-medium text-gray-700 italic">
                            {{ blog.excerpt }}
                        </div>
                        <div class="prose prose-lg max-w-none">
                            <div class="whitespace-pre-line text-gray-700" v-html="blog.content"></div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Additional Images -->
                <div v-if="blog.images && blog.images.length > 0" class="grid gap-4 sm:grid-cols-2">
                    <div 
                        v-for="(image, index) in blog.images" 
                        :key="index"
                        class="aspect-video overflow-hidden rounded-lg bg-gray-200"
                    >
                        <img :src="image" :alt="`${blog.title} - Image ${index + 1}`" class="h-full w-full object-cover" />
                    </div>
                </div>

                <!-- Tags -->
                <div v-if="blog.tags && blog.tags.length > 0" class="flex flex-wrap items-center gap-2">
                    <Tag class="h-4 w-4 text-gray-400" />
                    <span
                        v-for="(tag, index) in blog.tags"
                        :key="index"
                        class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700"
                    >
                        {{ tag }}
                    </span>
                </div>
            </article>

            <!-- Related Blogs -->
            <div v-if="relatedBlogs.length > 0" class="mt-16">
                <h2 class="mb-8 text-3xl font-extrabold text-gray-900">Related Posts</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Card
                        v-for="relatedBlog in relatedBlogs"
                        :key="relatedBlog.id"
                        class="group overflow-hidden bg-white text-gray-900 transition-all hover:shadow-xl"
                    >
                        <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-red-100 to-red-200">
                            <img
                                v-if="relatedBlog.featured_image"
                                :src="relatedBlog.featured_image"
                                :alt="relatedBlog.title"
                                class="h-full w-full object-cover transition-transform group-hover:scale-110"
                            />
                            <div v-else class="absolute inset-0 flex items-center justify-center">
                                <div class="flex items-center justify-center rounded-lg bg-white/90 backdrop-blur-sm p-6 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:bg-white/95">
                                    <img 
                                        src="/logo.png" 
                                        alt="Flyover BD" 
                                        class="h-16 w-auto opacity-80 transition-opacity duration-300 group-hover:opacity-100" 
                                    />
                                </div>
                            </div>
                        </div>
                        <CardContent class="p-6">
                            <h3 class="mb-2 text-xl font-bold text-gray-900 transition-colors group-hover:text-red-600">
                                {{ relatedBlog.title }}
                            </h3>
                            <p v-if="relatedBlog.excerpt" class="mb-4 line-clamp-2 text-sm text-gray-600">
                                {{ relatedBlog.excerpt }}
                            </p>
                            <div v-if="relatedBlog.published_at" class="mb-4 text-xs text-gray-500">
                                {{ relatedBlog.published_at }}
                            </div>
                            <Link
                                :href="`/blog/${relatedBlog.slug}`"
                                class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700"
                            >
                                Read More
                                <ArrowLeft class="ml-1 h-4 w-4 rotate-180" />
                            </Link>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

