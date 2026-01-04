<script setup lang="ts">
import VisaServiceCard from './VisaServiceCard.vue';
import { Globe } from 'lucide-vue-next';

interface VisaService {
    icon?: any;
    title: string;
    description: string;
}

const services: VisaService[] = [
    {
        icon: Globe,
        title: 'USA Visa',
        description: 'Complete assistance for US visa applications',
    },
    {
        icon: Globe,
        title: 'UK Visa',
        description: 'Expert guidance for UK visa processing',
    },
    {
        icon: Globe,
        title: 'UAE Visa',
        description: 'Fast and reliable UAE visa services',
    },
    {
        icon: Globe,
        title: 'More Countries',
        description: 'Visa services for 50+ countries',
    },
];
</script>

<template>
    <section id="visas" class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Visa Services</h2>
                <p class="mt-4 text-lg text-gray-600">
                    Get expert help with visa applications for countries worldwide
                </p>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <VisaServiceCard
                    v-for="(service, index) in services"
                    :key="index"
                    :icon="service.icon"
                    :title="service.title"
                    :description="service.description"
                />
            </div>
        </div>
    </section>
</template>

