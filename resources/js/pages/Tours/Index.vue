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
import { Search, X, MapPin, Calendar, Users } from 'lucide-vue-next';
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
        start_date?: string;
        end_date?: string;
        participants?: string;
    };
    canRegister?: boolean;
    seoMeta?: Record<string, any>;
}

const props = withDefaults(defineProps<Props>(), {
    filters: () => ({}),
    canRegister: true,
});

const country = ref(props.filters?.destination || '');
const startDate = ref(props.filters?.start_date || '');
const endDate = ref(props.filters?.end_date || '');
const participants = ref(props.filters?.participants ? parseInt(props.filters.participants) : 1);

const hasActiveFilters = computed(() => {
    return !!(country.value || startDate.value || endDate.value || (participants.value && participants.value > 1));
});

const performSearch = () => {
    const params: Record<string, string> = {};
    
    if (country.value) {
        params.destination = country.value;
    }
    if (startDate.value) {
        params.start_date = startDate.value;
    }
    if (endDate.value) {
        params.end_date = endDate.value;
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
    startDate.value = '';
    endDate.value = '';
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
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Tour Packages</h1>
                <p class="mt-2 text-lg text-gray-600">Discover amazing destinations with our carefully curated tours</p>
            </div>

            <!-- Search and Filters -->
            <Card class="mb-8 bg-white text-gray-900">
                <CardContent class="p-6">
                    <form @submit.prevent="performSearch" class="space-y-6">
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="space-y-2">
                                <Label for="country" class="text-sm font-semibold text-gray-700">Country</Label>
                                <div class="relative">
                                    <MapPin class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="country"
                                        v-model="country"
                                        type="text"
                                        placeholder="Search by country name"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="start_date" class="text-sm font-semibold text-gray-700">Start Date</Label>
                                <div class="relative">
                                    <Calendar class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="start_date"
                                        v-model="startDate"
                                        type="date"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="end_date" class="text-sm font-semibold text-gray-700">End Date</Label>
                                <div class="relative">
                                    <Calendar class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="end_date"
                                        v-model="endDate"
                                        type="date"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="participants" class="text-sm font-semibold text-gray-700">Participants</Label>
                                <div class="relative">
                                    <Users class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="participants"
                                        v-model.number="participants"
                                        type="number"
                                        placeholder="1"
                                        min="1"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <Button type="submit" class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800">
                                <Search class="mr-2 h-4 w-4" />
                                Search Tours
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
                    <div v-if="hasActiveFilters" class="mt-4 flex flex-wrap items-center gap-2 pt-4 border-t border-gray-200">
                        <span class="text-sm font-medium text-gray-700">Active filters:</span>
                        <Badge v-if="country" variant="secondary" class="gap-2">
                            Country: {{ country }}
                            <button @click="country = ''; performSearch()" class="ml-1 hover:text-red-600">
                                <X class="h-3 w-3" />
                            </button>
                        </Badge>
                        <Badge v-if="startDate" variant="secondary" class="gap-2">
                            Start: {{ startDate }}
                            <button @click="startDate = ''; performSearch()" class="ml-1 hover:text-red-600">
                                <X class="h-3 w-3" />
                            </button>
                        </Badge>
                        <Badge v-if="endDate" variant="secondary" class="gap-2">
                            End: {{ endDate }}
                            <button @click="endDate = ''; performSearch()" class="ml-1 hover:text-red-600">
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
            <div v-if="tours.data.length > 0" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
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
            <div v-else class="py-12 text-center">
                <p class="text-lg text-gray-500">No tours found. Try adjusting your search criteria.</p>
            </div>

            <!-- Pagination -->
            <div v-if="tours.links && tours.links.length > 3" class="mt-8 flex justify-center">
                <div class="flex space-x-2">
                    <Link
                        v-for="(link, index) in tours.links"
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

