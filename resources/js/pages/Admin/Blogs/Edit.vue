<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { ArrowLeft } from 'lucide-vue-next';
import { ref, watch } from 'vue';

interface Blog {
    id: number;
    title: string;
    slug: string;
    excerpt: string | null;
    content: string;
    featured_image: string | null;
    images: string[] | null;
    author: string | null;
    published_at: string | null;
    is_published: boolean;
    is_featured: boolean;
    category: string | null;
    tags: string[] | null;
    meta_title: string | null;
    meta_description: string | null;
    meta_keywords: string | null;
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
        title: 'Edit',
        href: '#',
    },
];

const tags = ref<string[]>(props.blog.tags && props.blog.tags.length > 0 ? [...props.blog.tags] : ['']);

const addTag = () => {
    tags.value.push('');
};
const removeTag = (index: number) => {
    tags.value.splice(index, 1);
};

const form = useForm({
    title: props.blog.title,
    slug: props.blog.slug,
    excerpt: props.blog.excerpt || '',
    content: props.blog.content,
    featured_image: props.blog.featured_image || '',
    images: (props.blog.images || []) as string[],
    author: props.blog.author || '',
    published_at: props.blog.published_at || '',
    is_published: props.blog.is_published,
    is_featured: props.blog.is_featured,
    category: props.blog.category || '',
    tags: (props.blog.tags || []) as string[],
    meta_title: props.blog.meta_title || '',
    meta_description: props.blog.meta_description || '',
    meta_keywords: props.blog.meta_keywords || '',
});

const submit = () => {
    // Filter out empty tags
    form.tags = tags.value.filter(tag => tag.trim() !== '');
    form.put(`/cp/blogs/${props.blog.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Edit Blog Post" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Edit Blog Post</h1>
                    <p class="text-muted-foreground">Update blog post information</p>
                </div>
                <Button variant="outline" as-child>
                    <Link href="/cp/blogs">
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Back
                    </Link>
                </Button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit">
                <div class="grid gap-6">
                    <!-- Basic Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Basic Information</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-2">
                                <Label for="title">Title *</Label>
                                <Input
                                    id="title"
                                    v-model="form.title"
                                    required
                                    placeholder="Blog Post Title"
                                />
                                <p v-if="form.errors.title" class="text-sm text-destructive">
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <Label for="slug">Slug</Label>
                                <Input
                                    id="slug"
                                    v-model="form.slug"
                                    placeholder="blog-post-slug"
                                />
                                <p v-if="form.errors.slug" class="text-sm text-destructive">
                                    {{ form.errors.slug }}
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <Label for="excerpt">Excerpt</Label>
                                <textarea
                                    id="excerpt"
                                    v-model="form.excerpt"
                                    rows="3"
                                    class="min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Short excerpt or summary"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="content">Content *</Label>
                                <textarea
                                    id="content"
                                    v-model="form.content"
                                    required
                                    rows="12"
                                    class="min-h-[240px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Blog post content"
                                />
                                <p v-if="form.errors.content" class="text-sm text-destructive">
                                    {{ form.errors.content }}
                                </p>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Media & Metadata -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Media & Metadata</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for="featured_image">Featured Image URL</Label>
                                    <Input
                                        id="featured_image"
                                        v-model="form.featured_image"
                                        placeholder="https://example.com/image.jpg"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="author">Author</Label>
                                    <Input
                                        id="author"
                                        v-model="form.author"
                                        placeholder="Author name"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="category">Category</Label>
                                    <Input
                                        id="category"
                                        v-model="form.category"
                                        placeholder="Blog category"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="published_at">Published Date</Label>
                                    <Input
                                        id="published_at"
                                        v-model="form.published_at"
                                        type="date"
                                    />
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label>Tags</Label>
                                <div class="space-y-2">
                                    <div
                                        v-for="(tag, index) in tags"
                                        :key="index"
                                        class="flex gap-2"
                                    >
                                        <Input
                                            v-model="tags[index]"
                                            placeholder="Tag name"
                                        />
                                        <Button
                                            v-if="tags.length > 1"
                                            type="button"
                                            variant="outline"
                                            size="icon"
                                            @click="removeTag(index)"
                                        >
                                            ×
                                        </Button>
                                    </div>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        @click="addTag"
                                    >
                                        + Add Tag
                                    </Button>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        id="is_published"
                                        v-model:checked="form.is_published"
                                    />
                                    <Label for="is_published">Published</Label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        id="is_featured"
                                        v-model:checked="form.is_featured"
                                    />
                                    <Label for="is_featured">Featured</Label>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- SEO -->
                    <Card>
                        <CardHeader>
                            <CardTitle>SEO Settings</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-2">
                                <Label for="meta_title">Meta Title</Label>
                                <Input
                                    id="meta_title"
                                    v-model="form.meta_title"
                                    placeholder="SEO meta title"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="meta_description">Meta Description</Label>
                                <textarea
                                    id="meta_description"
                                    v-model="form.meta_description"
                                    rows="3"
                                    class="min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="SEO meta description"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="meta_keywords">Meta Keywords</Label>
                                <Input
                                    id="meta_keywords"
                                    v-model="form.meta_keywords"
                                    placeholder="keyword1, keyword2, keyword3"
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4">
                        <Button
                            type="button"
                            variant="outline"
                            as-child
                        >
                            <Link href="/cp/blogs">Cancel</Link>
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Updating...' : 'Update Blog Post' }}
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

