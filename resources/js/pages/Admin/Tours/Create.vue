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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/cp/dashboard',
    },
    {
        title: 'Tour Packages',
        href: '/cp/tours',
    },
    {
        title: 'Create',
        href: '#',
    },
];

const form = useForm({
    title: '',
    slug: '',
    description: '',
    itinerary: '',
    highlights: '',
    images: [] as string[],
    thumbnail: '',
    price: 0,
    currency: 'BDT',
    duration_days: 1,
    destination: '',
    departure_location: '',
    start_date: '',
    end_date: '',
    max_participants: null as number | null,
    min_participants: 1,
    is_featured: false,
    is_active: true,
    included: '',
    excluded: '',
    terms_conditions: '',
    meta_title: '',
    meta_description: '',
    meta_keywords: '',
});

const submit = () => {
    form.post('/cp/tours', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Create Tour Package" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Create Tour Package</h1>
                    <p class="text-muted-foreground">Add a new tour package to your system</p>
                </div>
                <Button variant="outline" as-child>
                    <Link href="/cp/tours">
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
                                    placeholder="Tour Package Title"
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
                                    placeholder="tour-package-slug (auto-generated if empty)"
                                />
                                <p v-if="form.errors.slug" class="text-sm text-destructive">
                                    {{ form.errors.slug }}
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <Label for="description">Description *</Label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    required
                                    rows="4"
                                    class="min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Tour description"
                                />
                                <p v-if="form.errors.description" class="text-sm text-destructive">
                                    {{ form.errors.description }}
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <Label for="highlights">Highlights</Label>
                                <textarea
                                    id="highlights"
                                    v-model="form.highlights"
                                    rows="3"
                                    class="min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Key highlights of the tour"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="itinerary">Itinerary</Label>
                                <textarea
                                    id="itinerary"
                                    v-model="form.itinerary"
                                    rows="6"
                                    class="min-h-[120px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Detailed itinerary"
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Pricing & Details -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Pricing & Details</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for="price">Price *</Label>
                                    <Input
                                        id="price"
                                        v-model.number="form.price"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        required
                                    />
                                    <p v-if="form.errors.price" class="text-sm text-destructive">
                                        {{ form.errors.price }}
                                    </p>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="currency">Currency</Label>
                                    <Input
                                        id="currency"
                                        v-model="form.currency"
                                        maxlength="3"
                                        placeholder="BDT"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="duration_days">Duration (Days) *</Label>
                                    <Input
                                        id="duration_days"
                                        v-model.number="form.duration_days"
                                        type="number"
                                        min="1"
                                        required
                                    />
                                    <p v-if="form.errors.duration_days" class="text-sm text-destructive">
                                        {{ form.errors.duration_days }}
                                    </p>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="destination">Destination</Label>
                                    <Input
                                        id="destination"
                                        v-model="form.destination"
                                        placeholder="Tour destination"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="departure_location">Departure Location</Label>
                                    <Input
                                        id="departure_location"
                                        v-model="form.departure_location"
                                        placeholder="Departure location"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="min_participants">Min Participants</Label>
                                    <Input
                                        id="min_participants"
                                        v-model.number="form.min_participants"
                                        type="number"
                                        min="1"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="max_participants">Max Participants</Label>
                                    <Input
                                        id="max_participants"
                                        :model-value="form.max_participants ?? ''"
                                        type="number"
                                        min="1"
                                        @update:model-value="form.max_participants = $event ? Number($event) : null"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="start_date">Start Date</Label>
                                    <Input
                                        id="start_date"
                                        v-model="form.start_date"
                                        type="date"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="end_date">End Date</Label>
                                    <Input
                                        id="end_date"
                                        v-model="form.end_date"
                                        type="date"
                                    />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Additional Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Additional Information</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-2">
                                <Label for="included">What's Included</Label>
                                <textarea
                                    id="included"
                                    v-model="form.included"
                                    rows="3"
                                    class="min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Items included in the tour"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="excluded">What's Excluded</Label>
                                <textarea
                                    id="excluded"
                                    v-model="form.excluded"
                                    rows="3"
                                    class="min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Items excluded from the tour"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="terms_conditions">Terms & Conditions</Label>
                                <textarea
                                    id="terms_conditions"
                                    v-model="form.terms_conditions"
                                    rows="4"
                                    class="min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Terms and conditions"
                                />
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        id="is_featured"
                                        v-model:checked="form.is_featured"
                                    />
                                    <Label for="is_featured">Featured Tour</Label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        id="is_active"
                                        v-model:checked="form.is_active"
                                    />
                                    <Label for="is_active">Active</Label>
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
                            <Link href="/cp/tours">Cancel</Link>
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Creating...' : 'Create Tour Package' }}
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

