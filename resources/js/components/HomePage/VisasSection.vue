<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import VisaServiceCard from './VisaServiceCard.vue';
import { Globe } from 'lucide-vue-next';

interface VisaService {
    id: number;
    country: string;
    slug: string;
    description?: string | null;
    processing_time?: string | null;
    visa_fee?: number | null;
    currency?: string | null;
}

interface Props {
    visaServices?: VisaService[];
}

const props = withDefaults(defineProps<Props>(), {
    visaServices: () => [],
});

// Format description for display
const formatDescription = (visa: VisaService) => {
    if (visa.description) {
        return visa.description.length > 100 
            ? visa.description.substring(0, 100) + '...' 
            : visa.description;
    }
    return `Complete assistance for ${visa.country} visa applications`;
};
</script>

<template>
    <section id="visas" class="bg-gradient-to-b from-gray-50 to-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Visa Services</h2>
                <p class="mt-4 text-lg text-gray-600">
                    Get expert help with visa applications for countries worldwide
                </p>
            </div>
            <div v-if="visaServices.length > 0" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <VisaServiceCard
                    v-for="visa in visaServices"
                    :key="visa.id"
                    :id="visa.id"
                    :slug="visa.slug"
                    :icon="Globe"
                    :title="visa.country"
                    :description="formatDescription(visa)"
                />
            </div>
            <div v-else class="py-12 text-center">
                <p class="text-lg text-gray-500">No visa services available at the moment. Please check back later.</p>
            </div>
        </div>
    </section>
</template>

