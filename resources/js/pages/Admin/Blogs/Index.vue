<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Plus, Search, Edit, Trash2, Eye, FileText, Calendar } from 'lucide-vue-next';
import { ref } from 'vue';

interface Blog {
    id: number;
    title: string;
    slug: string;
    excerpt: string | null;
    featured_image: string | null;
    author: string | null;
    published_at: string | null;
    is_published: boolean;
    is_featured: boolean;
    category: string | null;
    views: number;
    created_at: string;
}

interface Props {
    blogs: {
        data: Blog[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: {
        search?: string;
        status?: string;
        category?: string;
    };
    categories: string[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/cp/dashboard',
    },
    {
        title: 'Blogs',
        href: '#',
    },
];

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || 'all');
const category = ref(props.filters.category || 'all');

const handleSearch = () => {
    router.get('/cp/blogs', {
        search: search.value || undefined,
        status: status.value !== 'all' ? status.value : undefined,
        category: category.value !== 'all' ? category.value : undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this blog post?')) {
        router.delete(`/cp/blogs/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Blogs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Blog Posts</h1>
                    <p class="text-muted-foreground">Manage your blog posts</p>
                </div>
                <Button as-child>
                    <Link href="/cp/blogs/create">
                        <Plus class="mr-2 h-4 w-4" />
                        Add Blog Post
                    </Link>
                </Button>
            </div>

            <!-- Filters -->
            <Card>
                <CardContent class="pt-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center">
                        <div class="flex-1">
                            <div class="relative">
                                <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    v-model="search"
                                    placeholder="Search blogs..."
                                    class="pl-9"
                                    @keyup.enter="handleSearch"
                                />
                            </div>
                        </div>
                        <select
                            v-model="status"
                            class="h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                            @change="handleSearch"
                        >
                            <option value="all">All Status</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="featured">Featured</option>
                        </select>
                        <select
                            v-if="categories.length > 0"
                            v-model="category"
                            class="h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                            @change="handleSearch"
                        >
                            <option value="all">All Categories</option>
                            <option
                                v-for="cat in categories"
                                :key="cat"
                                :value="cat"
                            >
                                {{ cat }}
                            </option>
                        </select>
                        <Button @click="handleSearch">Search</Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Blogs Table -->
            <Card>
                <CardHeader>
                    <CardTitle>All Blog Posts ({{ blogs.total }})</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Blog Post</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Author</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Category</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Published</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Views</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="blog in blogs.data"
                                    :key="blog.id"
                                    class="border-b hover:bg-muted/50"
                                >
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                v-if="blog.featured_image"
                                                class="h-12 w-12 rounded-md bg-muted bg-cover bg-center"
                                                :style="{ backgroundImage: `url(${blog.featured_image})` }"
                                            />
                                            <FileText
                                                v-else
                                                class="h-12 w-12 rounded-md bg-muted p-2 text-muted-foreground"
                                            />
                                            <div>
                                                <div class="font-medium">{{ blog.title }}</div>
                                                <div class="text-xs text-muted-foreground">
                                                    {{ blog.slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ blog.author || 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ blog.category || 'Uncategorized' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm text-muted-foreground">
                                            <span v-if="blog.published_at">
                                                {{ new Date(blog.published_at).toLocaleDateString() }}
                                            </span>
                                            <span v-else>Not published</span>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ blog.views }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
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
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-2">
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                as-child
                                            >
                                                <Link :href="`/cp/blogs/${blog.id}`">
                                                    <Eye class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                as-child
                                            >
                                                <Link :href="`/cp/blogs/${blog.id}/edit`">
                                                    <Edit class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                @click="handleDelete(blog.id)"
                                            >
                                                <Trash2 class="h-4 w-4 text-destructive" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="blogs.data.length === 0">
                                    <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                                        No blog posts found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="blogs.last_page > 1"
                        class="mt-4 flex items-center justify-between"
                    >
                        <div class="text-sm text-muted-foreground">
                            Showing {{ (blogs.current_page - 1) * blogs.per_page + 1 }} to
                            {{ Math.min(blogs.current_page * blogs.per_page, blogs.total) }} of
                            {{ blogs.total }} results
                        </div>
                        <div class="flex gap-2">
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="blogs.current_page === 1"
                                @click="router.get(blogs.current_page > 1 ? `/cp/blogs?page=${blogs.current_page - 1}` : '#')"
                            >
                                Previous
                            </Button>
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="blogs.current_page === blogs.last_page"
                                @click="router.get(blogs.current_page < blogs.last_page ? `/cp/blogs?page=${blogs.current_page + 1}` : '#')"
                            >
                                Next
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

