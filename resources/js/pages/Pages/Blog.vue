<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import WhatsAppButton from '@/components/HomePage/WhatsAppButton.vue';
import { Card, CardContent } from '@/components/ui/card';
import { Calendar, User, ArrowRight } from 'lucide-vue-next';

interface Blog {
    id: number;
    title: string;
    slug: string;
    excerpt?: string | null;
    featured_image?: string | null;
    author?: string | null;
    published_at?: string | null;
    category?: string | null;
    views: number;
}

interface Props {
    blogs: {
        data: Blog[];
        links: any;
        meta: any;
    };
    canRegister?: boolean;
}

withDefaults(defineProps<Props>(), {
    canRegister: true,
});
</script>

<template>
    <Head title="Blog - Flyover BD">
        <meta name="description" content="Read our latest travel tips, visa updates, and destination guides." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Our Blog</h1>
                <p class="mt-4 text-xl text-gray-600">
                    Travel tips, visa updates, and destination guides
                </p>
            </div>

            <div v-if="blogs.data.length > 0" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <Card
                    v-for="blog in blogs.data"
                    :key="blog.id"
                    class="group overflow-hidden transition-all hover:shadow-xl"
                >
                    <div v-if="blog.featured_image" class="aspect-video overflow-hidden bg-gray-200">
                        <img
                            :src="blog.featured_image"
                            :alt="blog.title"
                            class="h-full w-full object-cover transition-transform group-hover:scale-110"
                        />
                    </div>
                    <div v-else class="aspect-video bg-gradient-to-br from-red-100 to-red-200" />
                    <CardContent class="p-6">
                        <div v-if="blog.category" class="mb-2">
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-600">
                                {{ blog.category }}
                            </span>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-gray-900 transition-colors group-hover:text-red-600">
                            {{ blog.title }}
                        </h3>
                        <p v-if="blog.excerpt" class="mb-4 line-clamp-2 text-sm text-gray-600">
                            {{ blog.excerpt }}
                        </p>
                        <div class="mb-4 flex items-center space-x-4 text-xs text-gray-500">
                            <span v-if="blog.author" class="flex items-center">
                                <User class="mr-1 h-3 w-3" />
                                {{ blog.author }}
                            </span>
                            <span v-if="blog.published_at" class="flex items-center">
                                <Calendar class="mr-1 h-3 w-3" />
                                {{ blog.published_at }}
                            </span>
                        </div>
                        <Link
                            :href="`/blog/${blog.slug}`"
                            class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700"
                        >
                            Read More
                            <ArrowRight class="ml-1 h-4 w-4 transition-transform group-hover:translate-x-1" />
                        </Link>
                    </CardContent>
                </Card>
            </div>
            <div v-else class="py-12 text-center">
                <p class="text-lg text-gray-500">No blog posts available at the moment. Please check back later.</p>
            </div>

            <!-- Pagination -->
            <div v-if="blogs.links && blogs.links.length > 3" class="mt-8 flex justify-center">
                <div class="flex space-x-2">
                    <Link
                        v-for="(link, index) in blogs.links"
                        :key="index"
                        :href="link.url || '#'"
                        :class="[
                            'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                            link.active
                                ? 'bg-red-600 text-white'
                                : 'bg-white text-gray-700 hover:bg-gray-100',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>

        <Footer />
        <WhatsAppButton />
    </div>
</template>

