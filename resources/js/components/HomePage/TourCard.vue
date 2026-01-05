<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Plane, MapPin, ArrowRight } from 'lucide-vue-next';

interface Props {
    id?: number;
    slug?: string;
    title: string;
    description: string;
    price: number;
    currency?: string;
    duration: string;
    featured?: boolean;
    image?: string | null;
}

const props = withDefaults(defineProps<Props>(), {
    currency: 'BDT',
    featured: false,
    image: null,
});

// Truncate description if too long
const truncatedDescription = computed(() => {
    if (!props.description) return '';
    return props.description.length > 120 
        ? props.description.substring(0, 120) + '...' 
        : props.description;
});
</script>

<template>
    <Card class="group overflow-hidden border-gray-200 bg-white text-gray-900 transition-all duration-300 hover:scale-[1.02] hover:border-red-300 hover:shadow-2xl">
        <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-red-100 via-red-50 to-red-200">
            <div v-if="image" class="absolute inset-0">
                <img 
                    :src="image" 
                    :alt="title" 
                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" 
                />
            </div>
            <div v-else class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-red-100 to-red-200">
                <Plane class="h-20 w-20 text-red-600 opacity-20 transition-transform group-hover:scale-110" />
            </div>
            <!-- Overlay gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent opacity-0 transition-opacity group-hover:opacity-100"></div>
            <div v-if="featured" class="absolute top-4 right-4 z-10">
                <span class="rounded-full bg-gradient-to-r from-red-600 to-red-700 px-4 py-1.5 text-xs font-bold text-white shadow-lg">
                    ⭐ Featured
                </span>
            </div>
            <!-- Duration badge -->
            <div class="absolute bottom-4 left-4 z-10">
                <span class="rounded-lg bg-white/90 backdrop-blur-sm px-3 py-1.5 text-xs font-semibold text-gray-900 shadow-md">
                    <MapPin class="mr-1 inline h-3.5 w-3.5" />
                    {{ duration }}
                </span>
            </div>
        </div>
        <CardContent class="p-6">
            <h3 class="text-xl font-bold text-gray-900 transition-colors group-hover:text-red-600">{{ title }}</h3>
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-gray-600">
                {{ truncatedDescription }}
            </p>
            <div class="mt-5 flex items-baseline justify-between border-t border-gray-100 pt-4">
                <div>
                    <span class="text-3xl font-extrabold text-red-600">{{ currency === 'BDT' ? '৳' : currency }} {{ price.toLocaleString() }}</span>
                    <span class="ml-1 text-sm font-medium text-gray-500">/person</span>
                </div>
            </div>
            <Link 
                v-if="slug"
                :href="`/tours/${slug}`"
                class="relative z-10 mt-5 flex w-full items-center justify-center rounded-md bg-gradient-to-r from-red-600 to-red-700 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:from-red-700 hover:to-red-800 hover:shadow-lg"
            >
                View Details
                <ArrowRight class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
            </Link>
            <button 
                v-else
                disabled
                class="mt-5 flex w-full items-center justify-center rounded-md bg-gradient-to-r from-red-600 to-red-700 px-4 py-2.5 text-sm font-semibold text-white shadow-md opacity-50"
            >
                View Details
                <ArrowRight class="ml-2 h-4 w-4" />
            </button>
        </CardContent>
    </Card>
</template>

