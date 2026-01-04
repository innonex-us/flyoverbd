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
    <Card class="text-center hover:border-red-300 hover:shadow-md transition-all">
        <CardContent class="p-6">
            <div v-if="icon" class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                <component :is="icon" class="h-8 w-8 text-red-600" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ title }}</h3>
            <p class="mt-2 text-sm text-gray-600">
                {{ description }}
            </p>
        </CardContent>
    </Card>
</template>

