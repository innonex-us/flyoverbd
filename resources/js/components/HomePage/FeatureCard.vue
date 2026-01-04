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
    <div class="group text-center transition-transform hover:scale-105">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-red-50 to-red-100 shadow-lg transition-all group-hover:from-red-100 group-hover:to-red-200 group-hover:shadow-xl">
            <component :is="icon" class="h-10 w-10 text-red-600 transition-transform group-hover:scale-110" />
        </div>
        <h3 class="mt-5 text-lg font-bold text-gray-900">{{ title }}</h3>
        <p class="mt-3 text-sm leading-relaxed text-gray-600">
            {{ description }}
        </p>
    </div>
</template>

