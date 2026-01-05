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
    <Card class="group relative overflow-hidden border border-gray-200 bg-white text-gray-900 transition-all duration-300 hover:scale-[1.02] hover:border-red-300 hover:shadow-xl">
        <!-- Featured Badge -->
        <div v-if="featured" class="absolute top-2 right-2 z-20 sm:top-4 sm:right-4">
            <span class="inline-flex items-center gap-0.5 rounded-full bg-gradient-to-r from-red-600 to-red-700 px-2 py-1 text-[10px] font-bold text-white shadow-lg backdrop-blur-sm sm:gap-1 sm:px-3 sm:py-1.5 sm:text-xs">
                <span>⭐</span>
                <span class="hidden sm:inline">Featured</span>
            </span>
        </div>
        
        <!-- Image Section -->
        <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-red-50 via-red-100 to-red-200">
            <!-- Image (full width and height when available) -->
            <div v-if="image" class="absolute inset-0">
                <img 
                    :src="image" 
                    :alt="title" 
                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" 
                />
            </div>
            
            <!-- Logo Placeholder (only when no image) -->
            <div v-else class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-red-50 via-red-100 to-red-200">
                <div class="flex items-center justify-center rounded-lg bg-white/90 backdrop-blur-sm p-6 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:bg-white/95">
                    <img 
                        src="/logo.png" 
                        alt="Flyover BD" 
                        class="h-16 w-auto opacity-80 transition-opacity duration-300 group-hover:opacity-100" 
                    />
                </div>
            </div>
            
            <!-- Duration Badge -->
            <div class="absolute bottom-2 left-2 z-20 sm:bottom-4 sm:left-4">
                <span class="inline-flex items-center gap-1 rounded-lg bg-white/95 backdrop-blur-sm px-2 py-1 text-[10px] font-semibold text-gray-900 shadow-lg sm:gap-1.5 sm:px-3 sm:py-1.5 sm:text-xs">
                    <MapPin class="h-3 w-3 sm:h-3.5 sm:w-3.5" />
                    <span>{{ duration }}</span>
                </span>
            </div>
        </div>
        
        <!-- Content Section -->
        <CardContent class="p-4 sm:p-6">
            <h3 class="text-base font-bold leading-tight text-gray-900 transition-colors duration-200 group-hover:text-red-600 sm:text-lg lg:text-xl">
                {{ title }}
            </h3>
            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-gray-600 sm:mt-3 sm:text-sm">
                {{ truncatedDescription }}
            </p>
            
            <!-- Price Section -->
            <div class="mt-4 flex items-baseline gap-2 border-t border-gray-100 pt-3 sm:mt-6 sm:pt-5">
                <div class="flex-1">
                    <div class="flex items-baseline gap-1">
                        <span class="text-xl font-extrabold text-red-600 sm:text-2xl lg:text-3xl">
                            {{ currency === 'BDT' ? '৳' : currency }}{{ price.toLocaleString() }}
                        </span>
                        <span class="text-xs font-medium text-gray-500 sm:text-sm">/person</span>
                    </div>
                </div>
            </div>
            
            <!-- CTA Button -->
            <Link 
                v-if="slug"
                :href="`/tours/${slug}`"
                class="relative z-10 mt-3 flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-3 py-2 text-xs font-semibold text-white shadow-md transition-all duration-200 hover:from-red-700 hover:to-red-800 hover:shadow-lg hover:shadow-red-500/25 sm:mt-5 sm:px-4 sm:py-3 sm:text-sm"
            >
                <span>View Details</span>
                <ArrowRight class="h-3.5 w-3.5 sm:h-4 sm:w-4 transition-transform duration-200 group-hover:translate-x-1" />
            </Link>
            <button 
                v-else
                disabled
                class="mt-5 flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 text-sm font-semibold text-white shadow-md opacity-50"
            >
                <span>View Details</span>
                <ArrowRight class="h-4 w-4" />
            </button>
        </CardContent>
    </Card>
</template>

