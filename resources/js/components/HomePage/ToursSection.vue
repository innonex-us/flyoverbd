<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import TourCard from './TourCard.vue';
import { ArrowRight } from 'lucide-vue-next';

interface Tour {
    title: string;
    description: string;
    price: number;
    currency?: string;
    duration: string;
    featured?: boolean;
    image?: string;
}

interface Props {
    tours?: Tour[];
}

withDefaults(defineProps<Props>(), {
    tours: () => [
        {
            title: 'Exotic Beach Paradise',
            description: 'Experience pristine beaches and crystal-clear waters',
            price: 25000,
            duration: '5 Days',
            featured: true,
        },
        {
            title: 'Cultural Heritage Tour',
            description: 'Explore rich history and cultural landmarks',
            price: 18000,
            duration: '3 Days',
        },
        {
            title: 'Adventure Expedition',
            description: 'Thrilling adventures for the bold travelers',
            price: 35000,
            duration: '7 Days',
        },
    ],
});
</script>

<template>
    <section id="tours" class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 flex items-end justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Featured Tour Packages</h2>
                    <p class="mt-3 text-lg text-gray-600">Discover amazing destinations with our carefully curated tours</p>
                </div>
                <Link
                    href="#"
                    class="hidden items-center text-sm font-bold text-red-600 transition-all hover:scale-105 hover:text-red-700 sm:flex"
                >
                    View All Tours
                    <ArrowRight class="ml-2 h-4 w-4 transition-transform hover:translate-x-1" />
                </Link>
            </div>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <TourCard
                    v-for="(tour, index) in tours"
                    :key="index"
                    :title="tour.title"
                    :description="tour.description"
                    :price="tour.price"
                    :currency="tour.currency"
                    :duration="tour.duration"
                    :featured="tour.featured"
                    :image="tour.image"
                />
            </div>
        </div>
    </section>
</template>

