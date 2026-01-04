<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { ArrowLeft, X } from 'lucide-vue-next';
import { ref } from 'vue';

interface Tour {
    id: number;
    title: string;
    slug: string;
    description: string;
    itinerary: string | null;
    highlights: string | null;
    images: string[] | null;
    thumbnail: string | null;
    price: number;
    currency: string;
    duration_days: number;
    destination: string | null;
    departure_location: string | null;
    start_date: string | null;
    end_date: string | null;
    max_participants: number | null;
    min_participants: number;
    is_featured: boolean;
    is_active: boolean;
    included: string | null;
    excluded: string | null;
    terms_conditions: string | null;
    meta_title: string | null;
    meta_description: string | null;
    meta_keywords: string | null;
}

interface Props {
    tour: Tour;
}

const props = defineProps<Props>();

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
        title: 'Edit',
        href: '#',
    },
];

const thumbnailFile = ref<File | null>(null);
const thumbnailPreview = ref<string | null>(props.tour.thumbnail);
const removeThumbnailFlag = ref(false);

const existingImages = ref<string[]>(props.tour.images || []);
const imagesToRemove = ref<string[]>([]);
const additionalImages = ref<File[]>([]);
const additionalImagesPreview = ref<string[]>([]);

const form = useForm({
    title: props.tour.title,
    slug: props.tour.slug,
    description: props.tour.description,
    itinerary: props.tour.itinerary || '',
    highlights: props.tour.highlights || '',
    images: [] as File[],
    thumbnail: null as File | null,
    price: props.tour.price,
    currency: props.tour.currency,
    duration_days: props.tour.duration_days,
    destination: props.tour.destination || '',
    departure_location: props.tour.departure_location || '',
    start_date: props.tour.start_date || '',
    end_date: props.tour.end_date || '',
    max_participants: props.tour.max_participants,
    min_participants: props.tour.min_participants,
    is_featured: props.tour.is_featured,
    is_active: props.tour.is_active,
    included: props.tour.included || '',
    excluded: props.tour.excluded || '',
    terms_conditions: props.tour.terms_conditions || '',
    meta_title: props.tour.meta_title || '',
    meta_description: props.tour.meta_description || '',
    meta_keywords: props.tour.meta_keywords || '',
    remove_thumbnail: false,
    remove_images: [] as string[],
});

const handleThumbnailChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        thumbnailFile.value = target.files[0];
        form.thumbnail = target.files[0];
        form.remove_thumbnail = false;
        removeThumbnailFlag.value = false;
        const reader = new FileReader();
        reader.onload = (e) => {
            thumbnailPreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(target.files[0]);
    }
};

const removeThumbnail = () => {
    thumbnailFile.value = null;
    thumbnailPreview.value = null;
    form.thumbnail = null;
    form.remove_thumbnail = true;
    removeThumbnailFlag.value = true;
};

const handleAdditionalImagesChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        Array.from(target.files).forEach((file) => {
            additionalImages.value.push(file);
            form.images.push(file);
            const reader = new FileReader();
            reader.onload = (e) => {
                additionalImagesPreview.value.push(e.target?.result as string);
            };
            reader.readAsDataURL(file);
        });
    }
};

const removeExistingImage = (imageUrl: string) => {
    existingImages.value = existingImages.value.filter(img => img !== imageUrl);
    imagesToRemove.value.push(imageUrl);
    form.remove_images = imagesToRemove.value;
};

const removeAdditionalImage = (index: number) => {
    additionalImages.value.splice(index, 1);
    additionalImagesPreview.value.splice(index, 1);
    form.images.splice(index, 1);
};

const submit = () => {
    form.remove_images = imagesToRemove.value;
    form.put(`/cp/tours/${props.tour.id}`, {
        preserveScroll: true,
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Edit Tour Package" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Edit Tour Package</h1>
                    <p class="text-muted-foreground">Update tour package information</p>
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
                                    placeholder="tour-package-slug"
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
                                        v-model.number="form.max_participants"
                                        type="number"
                                        min="1"
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

                    <!-- Media -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Media</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <!-- Thumbnail Upload -->
                            <div class="grid gap-2">
                                <Label for="thumbnail">Thumbnail Image</Label>
                                <div v-if="thumbnailPreview && !removeThumbnailFlag" class="relative">
                                    <img
                                        :src="thumbnailPreview"
                                        alt="Thumbnail preview"
                                        class="h-48 w-full rounded-lg object-cover"
                                    />
                                    <Button
                                        type="button"
                                        variant="destructive"
                                        size="icon"
                                        class="absolute right-2 top-2"
                                        @click="removeThumbnail"
                                    >
                                        <X class="h-4 w-4" />
                                    </Button>
                                </div>
                                <div v-else>
                                    <Input
                                        id="thumbnail"
                                        type="file"
                                        accept="image/*"
                                        @change="handleThumbnailChange"
                                    />
                                    <p class="mt-1 text-xs text-muted-foreground">
                                        Upload a thumbnail image (max 2MB, jpeg, png, jpg, gif, webp)
                                    </p>
                                </div>
                                <p v-if="form.errors.thumbnail" class="text-sm text-destructive">
                                    {{ form.errors.thumbnail }}
                                </p>
                            </div>

                            <!-- Additional Images Upload -->
                            <div class="grid gap-2">
                                <Label>Additional Images</Label>
                                
                                <!-- Existing Images -->
                                <div v-if="existingImages.length > 0" class="grid grid-cols-2 gap-4 md:grid-cols-4 mb-4">
                                    <div
                                        v-for="(image, index) in existingImages"
                                        :key="index"
                                        class="relative"
                                    >
                                        <img
                                            :src="image"
                                            :alt="`Image ${index + 1}`"
                                            class="h-32 w-full rounded-lg object-cover"
                                        />
                                        <Button
                                            type="button"
                                            variant="destructive"
                                            size="icon"
                                            class="absolute right-2 top-2"
                                            @click="removeExistingImage(image)"
                                        >
                                            <X class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </div>

                                <!-- New Image Previews -->
                                <div v-if="additionalImagesPreview.length > 0" class="grid grid-cols-2 gap-4 md:grid-cols-4 mb-4">
                                    <div
                                        v-for="(preview, index) in additionalImagesPreview"
                                        :key="`new-${index}`"
                                        class="relative"
                                    >
                                        <img
                                            :src="preview"
                                            :alt="`New image ${index + 1}`"
                                            class="h-32 w-full rounded-lg object-cover"
                                        />
                                        <Button
                                            type="button"
                                            variant="destructive"
                                            size="icon"
                                            class="absolute right-2 top-2"
                                            @click="removeAdditionalImage(index)"
                                        >
                                            <X class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </div>

                                <Input
                                    id="additional_images"
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    @change="handleAdditionalImagesChange"
                                />
                                <p class="text-xs text-muted-foreground">
                                    Upload additional images (max 2MB each, jpeg, png, jpg, gif, webp)
                                </p>
                                <p v-if="form.errors.images" class="text-sm text-destructive">
                                    {{ form.errors.images }}
                                </p>
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
                            {{ form.processing ? 'Updating...' : 'Update Tour Package' }}
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

