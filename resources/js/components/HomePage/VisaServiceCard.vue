<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { type Component } from 'vue';

interface Props {
    id?: number;
    slug?: string;
    icon?: Component;
    title: string;
    description: string;
}

withDefaults(defineProps<Props>(), {
    icon: undefined,
});
</script>

<template>
    <Card 
        v-if="slug"
        as-child
        class="group relative text-center bg-white text-gray-900 transition-all duration-300 hover:scale-[1.03] hover:border-red-300 hover:shadow-xl cursor-pointer"
    >
        <Link :href="`/visas/${slug}`" class="block h-full">
            <CardContent class="p-4 sm:p-6 lg:p-8">
                <!-- Icon Container -->
                <div v-if="icon" class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-red-50 via-red-100 to-red-200 shadow-lg transition-all duration-300 group-hover:from-red-100 group-hover:to-red-200 group-hover:scale-110 group-hover:shadow-xl sm:mb-6 sm:h-16 sm:w-16 sm:rounded-2xl lg:h-20 lg:w-20">
                    <component :is="icon" class="h-6 w-6 text-red-600 transition-transform duration-300 group-hover:scale-110 sm:h-8 sm:w-8 lg:h-10 lg:w-10" />
                </div>
                
                <!-- Title -->
                <h3 class="text-sm font-bold leading-tight text-gray-900 transition-colors duration-200 group-hover:text-red-600 sm:text-base lg:text-lg">
                    {{ title }}
                </h3>
                
                <!-- Description -->
                <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-gray-600 sm:mt-4 sm:line-clamp-3 sm:text-sm">
                    {{ description }}
                </p>
                
                <!-- Hover Indicator -->
                <div class="mt-4 flex items-center justify-center gap-2 text-[10px] font-semibold text-red-600 opacity-0 transition-opacity duration-200 group-hover:opacity-100 sm:mt-6 sm:text-xs">
                    <span>Learn More</span>
                    <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </CardContent>
        </Link>
    </Card>
    <Card v-else class="group relative text-center bg-white text-gray-900 transition-all duration-300 hover:scale-[1.03] hover:border-red-300 hover:shadow-xl">
        <CardContent class="p-4 sm:p-6 lg:p-8">
            <!-- Icon Container -->
            <div v-if="icon" class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-red-50 via-red-100 to-red-200 shadow-lg transition-all duration-300 group-hover:from-red-100 group-hover:to-red-200 group-hover:scale-110 group-hover:shadow-xl sm:mb-6 sm:h-16 sm:w-16 sm:rounded-2xl lg:h-20 lg:w-20">
                <component :is="icon" class="h-6 w-6 text-red-600 transition-transform duration-300 group-hover:scale-110 sm:h-8 sm:w-8 lg:h-10 lg:w-10" />
            </div>
            
            <!-- Title -->
            <h3 class="text-sm font-bold leading-tight text-gray-900 transition-colors duration-200 group-hover:text-red-600 sm:text-base lg:text-lg">
                {{ title }}
            </h3>
            
            <!-- Description -->
            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-gray-600 sm:mt-4 sm:line-clamp-3 sm:text-sm">
                {{ description }}
            </p>
        </CardContent>
    </Card>
</template>

