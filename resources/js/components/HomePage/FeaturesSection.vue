<script setup lang="ts">
import FeatureCard from './FeatureCard.vue';
import { Shield, Clock, CheckCircle, Globe } from 'lucide-vue-next';

const features = [
    {
        icon: Shield,
        title: 'Secure & Trusted',
        description: 'Your documents handled with utmost security',
    },
    {
        icon: Clock,
        title: 'Fast Processing',
        description: 'Quick visa processing and tour bookings',
    },
    {
        icon: CheckCircle,
        title: 'Expert Support',
        description: 'Professional guidance every step of the way',
    },
    {
        icon: Globe,
        title: 'Worldwide',
        description: 'Services for destinations around the globe',
    },
];
</script>

<template>
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <FeatureCard
                    v-for="(feature, index) in features"
                    :key="index"
                    :icon="feature.icon"
                    :title="feature.title"
                    :description="feature.description"
                />
            </div>
        </div>
    </section>
</template>

