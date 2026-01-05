<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import SeoMeta from '@/components/SeoMeta.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import TourCard from '@/components/HomePage/TourCard.vue';
import WhatsAppButton from '@/components/HomePage/WhatsAppButton.vue';
import { MapPin, Calendar, Users, Check, X, ArrowLeft, Share2, Heart } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Tour {
    id: number;
    title: string;
    slug: string;
    description: string;
    itinerary?: string | null;
    highlights?: string | null;
    price: number;
    currency: string;
    duration_days: number;
    duration: string;
    destination?: string | null;
    departure_location?: string | null;
    start_date?: string | null;
    end_date?: string | null;
    max_participants?: number | null;
    min_participants?: number | null;
    featured: boolean;
    thumbnail?: string | null;
    images: string[];
    included?: string | null;
    excluded?: string | null;
    terms_conditions?: string | null;
}

interface RelatedTour {
    id: number;
    title: string;
    slug: string;
    price: number;
    currency: string;
    duration: string;
    thumbnail?: string | null;
}

interface Props {
    tour: Tour;
    relatedTours: RelatedTour[];
    seoMeta?: Record<string, any>;
    tourSchema?: Record<string, any>;
    breadcrumbs?: Array<{ title: string; href?: string }>;
}

const props = withDefaults(defineProps<Props>(), {
});

const mainImage = computed(() => {
    if (props.tour.thumbnail) return props.tour.thumbnail;
    if (props.tour.images && props.tour.images.length > 0) return props.tour.images[0];
    return null;
});

const otherImages = computed(() => {
    if (!props.tour.images || props.tour.images.length === 0) return [];
    const main = mainImage.value;
    return props.tour.images.filter(img => img && img !== main);
});

const includedItems = computed(() => {
    if (!props.tour.included) return [];
    return props.tour.included.split('\n').filter(item => item.trim());
});

const excludedItems = computed(() => {
    if (!props.tour.excluded) return [];
    return props.tour.excluded.split('\n').filter(item => item.trim());
});

const highlightsList = computed(() => {
    if (!props.tour.highlights) return [];
    return props.tour.highlights.split(',').map(h => h.trim());
});

const isFavorited = ref(false);

const handleShare = () => {
    if (navigator.share) {
        navigator.share({
            title: props.tour.title,
            text: props.tour.description?.substring(0, 160) || '',
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

const handleFavorite = () => {
    isFavorited.value = !isFavorited.value;
    // TODO: Implement favorite functionality with backend
};

const handleBookNow = () => {
    // Navigate to booking form
    router.visit(`/tours/${props.tour.slug}/book`);
};

const handleContactUs = () => {
    router.visit('/contact', {
        query: {
            tour_id: props.tour.id,
            tour_title: props.tour.title,
            subject: `Inquiry about ${props.tour.title}`,
        },
    });
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
        :schema="tourSchema"
        :breadcrumbs="breadcrumbs"
    />

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation />
        
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <Link href="/tours" class="mb-6 inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
                <ArrowLeft class="mr-2 h-4 w-4" />
                Back to Tours
            </Link>

            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Image Gallery -->
                    <div class="space-y-4">
                        <div class="aspect-video overflow-hidden rounded-2xl bg-gray-200">
                            <img 
                                v-if="mainImage" 
                                :src="mainImage" 
                                :alt="tour.title"
                                class="h-full w-full object-cover"
                            />
                            <div v-else class="flex h-full items-center justify-center">
                                <MapPin class="h-24 w-24 text-gray-400" />
                            </div>
                        </div>
                        <div v-if="otherImages.length > 0" class="grid grid-cols-4 gap-4">
                            <div 
                                v-for="(image, index) in otherImages.slice(0, 4)" 
                                :key="index"
                                class="aspect-video overflow-hidden rounded-lg bg-gray-200"
                            >
                                <img :src="image" :alt="`${tour.title} - Image ${index + 2}`" class="h-full w-full object-cover" />
                            </div>
                        </div>
                    </div>

                    <!-- Tour Details -->
                    <Card class="bg-white text-gray-900">
                        <CardContent class="p-4 sm:p-6 lg:p-8">
                            <div class="mb-6">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h1 class="text-xl font-extrabold text-gray-900 sm:text-2xl lg:text-3xl">{{ tour.title }}</h1>
                                        <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-600 sm:space-x-4 sm:text-sm">
                                            <span v-if="tour.destination" class="flex items-center">
                                                <MapPin class="mr-1 h-4 w-4" />
                                                {{ tour.destination }}
                                            </span>
                                            <span class="flex items-center">
                                                <Calendar class="mr-1 h-4 w-4" />
                                                {{ tour.duration }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <Button variant="outline" size="icon" @click="handleShare" title="Share">
                                            <Share2 class="h-4 w-4" />
                                        </Button>
                                        <Button 
                                            variant="outline" 
                                            size="icon" 
                                            @click="handleFavorite"
                                            :class="isFavorited ? 'text-red-600 border-red-300' : ''"
                                            :title="isFavorited ? 'Remove from favorites' : 'Add to favorites'"
                                        >
                                            <Heart 
                                                class="h-4 w-4" 
                                                :class="isFavorited ? 'fill-current' : ''"
                                            />
                                        </Button>
                                    </div>
                                </div>
                            </div>

                            <div class="prose max-w-none">
                                <h2 class="text-lg font-bold text-gray-900 sm:text-xl lg:text-2xl">Description</h2>
                                <p class="mt-3 text-sm text-gray-700 leading-relaxed sm:mt-4 sm:text-base">{{ tour.description }}</p>
                            </div>

                            <div v-if="highlightsList.length > 0" class="mt-6 sm:mt-8">
                                <h2 class="text-lg font-bold text-gray-900 sm:text-xl lg:text-2xl">Highlights</h2>
                                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                    <div v-for="(highlight, index) in highlightsList" :key="index" class="flex items-center text-gray-700">
                                        <Check class="mr-2 h-5 w-5 flex-shrink-0 text-red-600" />
                                        <span>{{ highlight }}</span>
                                    </div>
                                </div>
                            </div>

                            <div v-if="tour.itinerary" class="mt-6 sm:mt-8">
                                <h2 class="text-lg font-bold text-gray-900 sm:text-xl lg:text-2xl">Itinerary</h2>
                                <div class="mt-3 whitespace-pre-line text-sm text-gray-700 sm:mt-4 sm:text-base">{{ tour.itinerary }}</div>
                            </div>

                            <div v-if="includedItems.length > 0 || excludedItems.length > 0" class="mt-6 grid gap-6 sm:mt-8 sm:grid-cols-2 sm:gap-8">
                                <div v-if="includedItems.length > 0">
                                    <h3 class="text-base font-bold text-gray-900 sm:text-lg lg:text-xl">What's Included</h3>
                                    <ul class="mt-4 space-y-2">
                                        <li v-for="(item, index) in includedItems" :key="index" class="flex items-start text-gray-700">
                                            <Check class="mr-2 h-5 w-5 flex-shrink-0 text-green-600" />
                                            <span>{{ item }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="excludedItems.length > 0">
                                    <h3 class="text-base font-bold text-gray-900 sm:text-lg lg:text-xl">What's Excluded</h3>
                                    <ul class="mt-4 space-y-2">
                                        <li v-for="(item, index) in excludedItems" :key="index" class="flex items-start text-gray-700">
                                            <X class="mr-2 h-5 w-5 flex-shrink-0 text-red-600" />
                                            <span>{{ item }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div v-if="tour.terms_conditions" class="mt-6 sm:mt-8">
                                <h2 class="text-lg font-bold text-gray-900 sm:text-xl lg:text-2xl">Terms & Conditions</h2>
                                <div class="mt-3 whitespace-pre-line text-sm text-gray-700 sm:mt-4 sm:text-base">{{ tour.terms_conditions }}</div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <Card class="sticky top-4 bg-white text-gray-900 sm:top-24">
                        <CardContent class="p-4 sm:p-6">
                            <div class="mb-4 sm:mb-6">
                                <div class="flex items-baseline">
                                    <span class="text-2xl font-extrabold text-red-600 sm:text-3xl lg:text-4xl">
                                        {{ tour.currency === 'BDT' ? '৳' : tour.currency }} {{ tour.price.toLocaleString() }}
                                    </span>
                                    <span class="ml-1 text-xs text-gray-500 sm:ml-2 sm:text-sm">/person</span>
                                </div>
                            </div>

                            <div class="space-y-4 border-t border-gray-200 pt-6">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Duration</span>
                                    <span class="font-semibold text-gray-900">{{ tour.duration }}</span>
                                </div>
                                <div v-if="tour.departure_location" class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Departure</span>
                                    <span class="font-semibold text-gray-900">{{ tour.departure_location }}</span>
                                </div>
                                <div v-if="tour.max_participants" class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Max Participants</span>
                                    <span class="font-semibold text-gray-900">{{ tour.max_participants }}</span>
                                </div>
                            </div>

                            <Button 
                                class="mt-6 w-full bg-gradient-to-r from-red-600 to-red-700 text-base font-bold text-white shadow-lg transition-all hover:from-red-700 hover:to-red-800 hover:shadow-xl"
                                @click="handleBookNow"
                            >
                                Book Now
                            </Button>
                            <Button 
                                variant="outline" 
                                class="mt-3 w-full"
                                @click="handleContactUs"
                            >
                                Contact Us
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <!-- Related Tours -->
            <div v-if="relatedTours.length > 0" class="mt-8 sm:mt-12 lg:mt-16">
                <h2 class="mb-6 text-xl font-extrabold text-gray-900 sm:mb-8 sm:text-2xl lg:text-3xl">Related Tours</h2>
                <div class="grid grid-cols-2 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <TourCard
                        v-for="relatedTour in relatedTours"
                        :key="relatedTour.id"
                        :id="relatedTour.id"
                        :slug="relatedTour.slug"
                        :title="relatedTour.title"
                        :description="''"
                        :price="relatedTour.price"
                        :currency="relatedTour.currency"
                        :duration="relatedTour.duration"
                        :image="relatedTour.thumbnail"
                    />
                </div>
            </div>
        </div>

        <Footer />
        <WhatsAppButton />
    </div>
</template>

