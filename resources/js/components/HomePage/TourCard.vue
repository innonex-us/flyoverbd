<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Plane, MapPin, ArrowRight } from 'lucide-vue-next';

interface Props {
    title: string;
    description: string;
    price: number;
    currency?: string;
    duration: string;
    featured?: boolean;
    image?: string;
}

withDefaults(defineProps<Props>(), {
    currency: 'BDT',
    featured: false,
});
</script>

<template>
    <Card class="group overflow-hidden transition-all hover:shadow-xl">
        <div class="aspect-video bg-gradient-to-br from-red-100 to-red-200 relative">
            <div v-if="image" class="absolute inset-0">
                <img :src="image" :alt="title" class="h-full w-full object-cover" />
            </div>
            <div v-else class="absolute inset-0 flex items-center justify-center">
                <Plane class="h-16 w-16 text-red-600 opacity-20" />
            </div>
            <div v-if="featured" class="absolute top-4 right-4">
                <span class="rounded-full bg-red-600 px-3 py-1 text-xs font-semibold text-white">
                    Featured
                </span>
            </div>
        </div>
        <CardContent class="p-6">
            <h3 class="text-xl font-semibold text-gray-900">{{ title }}</h3>
            <p class="mt-2 text-sm text-gray-600">
                {{ description }}
            </p>
            <div class="mt-4 flex items-center justify-between">
                <div>
                    <span class="text-2xl font-bold text-red-600">{{ currency === 'BDT' ? '৳' : currency }} {{ price.toLocaleString() }}</span>
                    <span class="text-sm text-gray-500">/person</span>
                </div>
                <span class="text-sm text-gray-500">{{ duration }}</span>
            </div>
            <Button class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white">
                View Details
                <ArrowRight class="ml-2 h-4 w-4" />
            </Button>
        </CardContent>
    </Card>
</template>

