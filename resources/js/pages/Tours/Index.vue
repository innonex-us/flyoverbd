<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent } from '@/components/ui/card';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import TourCard from '@/components/HomePage/TourCard.vue';
import { Search, Filter } from 'lucide-vue-next';
import { ref } from 'vue';

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
    };
    canRegister?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    filters: () => ({}),
    canRegister: true,
});

const search = ref(props.filters?.search || '');
const destination = ref(props.filters?.destination || '');

const performSearch = () => {
    router.get('/tours', {
        search: search.value || undefined,
        destination: destination.value || undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};
</script>

<template>
    <Head title="Tour Packages - Flyover BD">
        <meta name="description" content="Browse our amazing tour packages. Discover destinations worldwide with Flyover BD." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Tour Packages</h1>
                <p class="mt-2 text-lg text-gray-600">Discover amazing destinations with our carefully curated tours</p>
            </div>

            <!-- Search and Filters -->
            <Card class="mb-8">
                <CardContent class="p-6">
                    <form @submit.prevent="performSearch" class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <Input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search tours..."
                                    class="w-full"
                                />
                            </div>
                            <div>
                                <Input
                                    v-model="destination"
                                    type="text"
                                    placeholder="Destination"
                                    class="w-full"
                                />
                            </div>
                            <Button type="submit" class="w-full bg-red-600 hover:bg-red-700">
                                <Search class="mr-2 h-4 w-4" />
                                Search
                            </Button>
                        </div>
                    </form>
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
    </div>
</template>

