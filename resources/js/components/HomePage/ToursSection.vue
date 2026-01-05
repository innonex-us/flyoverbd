<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import TourCard from './TourCard.vue';
import { ArrowRight } from 'lucide-vue-next';

interface Tour {
    id: number;
    title: string;
    slug: string;
    description: string;
    price: number;
    currency?: string;
    duration: string;
    duration_days?: number;
    featured?: boolean;
    thumbnail?: string | null;
    image?: string | null;
    destination?: string | null;
}

interface Props {
    tours?: Tour[];
}

withDefaults(defineProps<Props>(), {
    tours: () => [],
});
</script>

<template>
    <section id="tours" class="bg-white py-8 sm:py-10 lg:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:mb-8 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl lg:text-4xl">Featured Tour Packages</h2>
                    <p class="mt-2 text-base text-gray-600 sm:mt-3 sm:text-lg">Discover amazing destinations with our carefully curated tours</p>
                </div>
                <Link
                    href="/tours"
                    class="hidden items-center text-sm font-bold text-red-600 transition-all hover:scale-105 hover:text-red-700 sm:flex"
                >
                    View All Tours
                    <ArrowRight class="ml-2 h-4 w-4 transition-transform hover:translate-x-1" />
                </Link>
            </div>
            <div v-if="tours.length > 0" class="grid grid-cols-2 gap-4 sm:gap-6 lg:gap-8 lg:grid-cols-3">
                <TourCard
                    v-for="tour in tours"
                    :key="tour.id"
                    :id="tour.id"
                    :slug="tour.slug"
                    :title="tour.title"
                    :description="tour.description"
                    :price="tour.price"
                    :currency="tour.currency"
                    :duration="tour.duration"
                    :featured="tour.featured"
                    :image="tour.image || tour.thumbnail"
                />
            </div>
            <div v-else class="py-8 text-center">
                <p class="text-lg text-gray-500">No tours available at the moment. Please check back later.</p>
            </div>
        </div>
    </section>
</template>

