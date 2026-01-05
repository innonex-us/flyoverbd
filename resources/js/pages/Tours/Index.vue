<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import SeoMeta from '@/components/SeoMeta.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import TourCard from '@/components/HomePage/TourCard.vue';
import WhatsAppButton from '@/components/HomePage/WhatsAppButton.vue';
import { Search, X, MapPin, Users } from 'lucide-vue-next';
import { ref, computed } from 'vue';

interface Tour {
    id: number;
    title: string;
    slug: string;
    description: string;
    price: number;
    currency: string;
    duration: string;
    duration_days?: number;
    featured: boolean;
    thumbnail?: string | null;
    destination?: string | null;
}

interface Props {
    tours: {
        data: Tour[];
        links: any;
        meta: any;
    };
    filters?: {
        search?: string;
        destination?: string;
        participants?: string;
    };
    seoMeta?: Record<string, any>;
}

const props = withDefaults(defineProps<Props>(), {
    filters: () => ({}),
});

const country = ref(props.filters?.destination || '');
const participants = ref(props.filters?.participants ? parseInt(props.filters.participants) : 1);

const hasActiveFilters = computed(() => {
    return !!(country.value || (participants.value && participants.value > 1));
});

const performSearch = () => {
    const params: Record<string, string> = {};
    
    if (country.value) {
        params.destination = country.value;
    }
    if (participants.value && participants.value > 1) {
        params.participants = participants.value.toString();
    }
    
    router.get('/tours', params, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    country.value = '';
    participants.value = 1;
    router.get('/tours', {}, {
        preserveState: true,
        replace: true,
    });
};
</script>

<template>
    <SeoMeta
        :title="seoMeta?.title"
        :description="seoMeta?.description"
        :canonical="seoMeta?.canonical"
    />

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation />
        
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="mb-6 sm:mb-8">
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl lg:text-4xl">Tour Packages</h1>
                <p class="mt-2 text-base text-gray-600 sm:text-lg">Discover amazing destinations with our carefully curated tours</p>
            </div>

            <!-- Search and Filters -->
            <Card class="mb-6 bg-white text-gray-900 sm:mb-8">
                <CardContent class="p-4 sm:p-6">
                    <form @submit.prevent="performSearch" class="space-y-4 sm:space-y-6">
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-5">
                            <div class="space-y-1.5 sm:space-y-2">
                                <Label for="country" class="text-xs font-semibold text-gray-700 sm:text-sm">Country</Label>
                                <div class="relative">
                                    <MapPin class="absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 sm:left-3 sm:h-5 sm:w-5" />
                                    <Input
                                        id="country"
                                        v-model="country"
                                        type="text"
                                        placeholder="Country"
                                        class="h-10 border-gray-300 pl-8 text-sm focus:border-red-500 focus:ring-red-500 sm:h-12 sm:pl-10"
                                    />
                                </div>
                            </div>
                            <div class="space-y-1.5 sm:space-y-2">
                                <Label for="participants" class="text-xs font-semibold text-gray-700 sm:text-sm">People</Label>
                                <div class="relative">
                                    <Users class="absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 sm:left-3 sm:h-5 sm:w-5" />
                                    <Input
                                        id="participants"
                                        v-model.number="participants"
                                        type="number"
                                        placeholder="1"
                                        min="1"
                                        class="h-10 border-gray-300 pl-8 text-sm focus:border-red-500 focus:ring-red-500 sm:h-12 sm:pl-10"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 sm:flex-row sm:gap-3">
                            <Button type="submit" class="flex-1 bg-linear-to-r from-red-600 to-red-700 text-sm hover:from-red-700 hover:to-red-800 sm:text-base">
                                <Search class="mr-2 h-4 w-4" />
                                <span class="hidden sm:inline">Search Tours</span>
                                <span class="sm:hidden">Search</span>
                            </Button>
                            <Button
                                v-if="hasActiveFilters"
                                type="button"
                                variant="outline"
                                @click="clearFilters"
                                class="px-6"
                            >
                                <X class="mr-2 h-4 w-4" />
                                Clear
                            </Button>
                        </div>
                    </form>
                    
                    <!-- Active Filters Display -->
                    <div v-if="hasActiveFilters" class="mt-3 flex flex-wrap items-center gap-2 pt-3 text-xs sm:mt-4 sm:pt-4 sm:text-sm border-t border-gray-200">
                        <span class="font-medium text-gray-700">Active filters:</span>
                        <Badge v-if="country" variant="secondary" class="gap-2">
                            Country: {{ country }}
                            <button @click="country = ''; performSearch()" class="ml-1 hover:text-red-600">
                                <X class="h-3 w-3" />
                            </button>
                        </Badge>
                        <Badge v-if="participants && participants > 1" variant="secondary" class="gap-2">
                            Participants: {{ participants }}
                            <button @click="participants = 1; performSearch()" class="ml-1 hover:text-red-600">
                                <X class="h-3 w-3" />
                            </button>
                        </Badge>
                    </div>
                </CardContent>
            </Card>

            <!-- Tours Grid -->
            <div v-if="tours.data.length > 0" class="grid grid-cols-2 gap-4 sm:gap-6 lg:gap-8 lg:grid-cols-3">
                <TourCard
                    v-for="tour in tours.data"
                    :key="tour.id"
                    :id="tour.id"
                    :slug="tour.slug"
                    :title="tour.title"
                    :description="tour.description"
                    :price="tour.price"
                    :currency="tour.currency"
                    :duration="tour.duration"
                    :featured="tour.featured"
                    :image="tour.thumbnail"
                />
            </div>
            <div v-else class="py-8 text-center sm:py-12">
                <p class="text-sm text-gray-500 sm:text-base lg:text-lg">No tours found. Try adjusting your search criteria.</p>
            </div>

            <!-- Pagination -->
            <div v-if="tours.links && tours.links.length > 3" class="mt-6 flex justify-center sm:mt-8">
                <div class="flex flex-wrap justify-center gap-1 sm:space-x-2">
                    <Link
                        v-for="(link, index) in tours.links"
                        :key="index"
                        :href="link.url || '#'"
                        :class="[
                            'px-2 py-1.5 rounded-md text-xs font-medium transition-colors sm:px-4 sm:py-2 sm:text-sm',
                            link.active
                                ? 'bg-red-600 text-white'
                                : 'bg-white text-gray-700 hover:bg-gray-100',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                    >
                        <span v-html="link.label"></span>
                    </Link>
                </div>
            </div>
        </div>

        <Footer />
        <WhatsAppButton />
    </div>
</template>

