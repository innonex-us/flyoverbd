<script setup lang="ts">
import { type Component } from 'vue';

interface Props {
    icon: Component;
    title: string;
    description: string;
}

defineProps<Props>();
</script>

<template>
    <div class="text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
            <component :is="icon" class="h-8 w-8 text-red-600" />
        </div>
        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ title }}</h3>
        <p class="mt-2 text-sm text-gray-600">
            {{ description }}
        </p>
    </div>
</template>

