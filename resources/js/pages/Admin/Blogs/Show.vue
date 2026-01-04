<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Edit, Calendar, User, Eye, FileText } from 'lucide-vue-next';

interface Blog {
    id: number;
    title: string;
    slug: string;
    excerpt: string | null;
    content: string;
    featured_image: string | null;
    images: string[] | null;
    author: string | null;
    author_id: number | null;
    published_at: string | null;
    is_published: boolean;
    is_featured: boolean;
    category: string | null;
    tags: string[] | null;
    views: number;
    meta_title: string | null;
    meta_description: string | null;
    meta_keywords: string | null;
    created_at: string;
    updated_at: string;
}

interface Props {
    blog: Blog;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/cp/dashboard',
    },
    {
        title: 'Blogs',
        href: '/cp/blogs',
    },
    {
        title: props.blog.title,
        href: '#',
    },
];
</script>

<template>
    <Head :title="blog.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">{{ blog.title }}</h1>
                    <p class="text-muted-foreground">Blog Post Details</p>
                </div>
                <div class="flex gap-2">
                    <Button variant="outline" as-child>
                        <Link href="/cp/blogs">
                            <ArrowLeft class="mr-2 h-4 w-4" />
                            Back
                        </Link>
                    </Button>
                    <Button as-child>
                        <Link :href="`/cp/blogs/${blog.id}/edit`">
                            <Edit class="mr-2 h-4 w-4" />
                            Edit
                        </Link>
                    </Button>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <!-- Main Content -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Featured Image -->
                    <Card v-if="blog.featured_image">
                        <CardContent class="p-0">
                            <img
                                :src="blog.featured_image"
                                :alt="blog.title"
                                class="h-auto w-full rounded-lg"
                            />
                        </CardContent>
                    </Card>

                    <!-- Content -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Content</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div
                                class="prose max-w-none dark:prose-invert"
                                v-html="blog.content.replace(/\n/g, '<br>')"
                            />
                        </CardContent>
                    </Card>

                    <!-- Excerpt -->
                    <Card v-if="blog.excerpt">
                        <CardHeader>
                            <CardTitle>Excerpt</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p class="text-muted-foreground">{{ blog.excerpt }}</p>
                        </CardContent>
                    </Card>

                    <!-- Additional Images -->
                    <Card v-if="blog.images && blog.images.length > 0">
                        <CardHeader>
                            <CardTitle>Additional Images</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                <img
                                    v-for="(image, index) in blog.images"
                                    :key="index"
                                    :src="image"
                                    :alt="`${blog.title} - Image ${index + 1}`"
                                    class="h-auto w-full rounded-lg"
                                />
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status & Info -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Status & Information</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium">Status:</span>
                                <Badge
                                    v-if="blog.is_published"
                                    variant="default"
                                >
                                    Published
                                </Badge>
                                <Badge
                                    v-else
                                    variant="secondary"
                                >
                                    Draft
                                </Badge>
                                <Badge
                                    v-if="blog.is_featured"
                                    variant="outline"
                                >
                                    Featured
                                </Badge>
                            </div>

                            <div class="flex items-center gap-2 text-sm">
                                <Eye class="h-4 w-4 text-muted-foreground" />
                                <span>{{ blog.views }} views</span>
                            </div>

                            <div class="flex items-center gap-2 text-sm">
                                <Calendar class="h-4 w-4 text-muted-foreground" />
                                <span>
                                    Published: {{ blog.published_at ? new Date(blog.published_at).toLocaleDateString() : 'Not published' }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 text-sm">
                                <User class="h-4 w-4 text-muted-foreground" />
                                <span>{{ blog.author || 'N/A' }}</span>
                            </div>

                            <div v-if="blog.category" class="text-sm">
                                <span class="font-medium">Category:</span>
                                <span class="ml-2">{{ blog.category }}</span>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Tags -->
                    <Card v-if="blog.tags && blog.tags.length > 0">
                        <CardHeader>
                            <CardTitle>Tags</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="flex flex-wrap gap-2">
                                <Badge
                                    v-for="tag in blog.tags"
                                    :key="tag"
                                    variant="outline"
                                >
                                    {{ tag }}
                                </Badge>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- SEO Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle>SEO Information</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div v-if="blog.meta_title">
                                <span class="text-sm font-medium">Meta Title:</span>
                                <p class="text-sm text-muted-foreground">{{ blog.meta_title }}</p>
                            </div>
                            <div v-if="blog.meta_description">
                                <span class="text-sm font-medium">Meta Description:</span>
                                <p class="text-sm text-muted-foreground">{{ blog.meta_description }}</p>
                            </div>
                            <div v-if="blog.meta_keywords">
                                <span class="text-sm font-medium">Meta Keywords:</span>
                                <p class="text-sm text-muted-foreground">{{ blog.meta_keywords }}</p>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Dates -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Dates</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-2 text-sm">
                            <div>
                                <span class="font-medium">Created:</span>
                                <span class="ml-2 text-muted-foreground">
                                    {{ new Date(blog.created_at).toLocaleString() }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium">Updated:</span>
                                <span class="ml-2 text-muted-foreground">
                                    {{ new Date(blog.updated_at).toLocaleString() }}
                                </span>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

