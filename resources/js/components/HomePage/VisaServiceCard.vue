<script setup lang="ts">
import { Card, CardContent } from '@/components/ui/card';
import { type Component } from 'vue';

interface Props {
    icon?: Component;
    title: string;
    description: string;
}

withDefaults(defineProps<Props>(), {
    icon: undefined,
});
</script>

<template>
    <Card class="group text-center transition-all duration-300 hover:scale-105 hover:border-red-300 hover:shadow-xl">
        <CardContent class="p-8">
            <div v-if="icon" class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-red-50 to-red-100 shadow-lg transition-all group-hover:from-red-100 group-hover:to-red-200 group-hover:shadow-xl">
                <component :is="icon" class="h-10 w-10 text-red-600 transition-transform group-hover:scale-110" />
            </div>
            <h3 class="mt-6 text-lg font-bold text-gray-900 transition-colors group-hover:text-red-600">{{ title }}</h3>
            <p class="mt-3 text-sm leading-relaxed text-gray-600">
                {{ description }}
            </p>
        </CardContent>
    </Card>
</template>

