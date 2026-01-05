<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import HeroSearch from '@/components/HomePage/HeroSearch.vue';
import FeaturesSection from '@/components/HomePage/FeaturesSection.vue';
import ToursSection from '@/components/HomePage/ToursSection.vue';
import VisasSection from '@/components/HomePage/VisasSection.vue';
import CTASection from '@/components/HomePage/CTASection.vue';
import Footer from '@/components/HomePage/Footer.vue';
import WhatsAppButton from '@/components/HomePage/WhatsAppButton.vue';

interface Tour {
    id: number;
    title: string;
    slug: string;
    description: string;
    price: number;
    currency?: string;
    duration: string;
    duration_days?: number;
    featured?: boolean;
    thumbnail?: string | null;
    image?: string | null;
    destination?: string | null;
}

interface VisaService {
    id: number;
    country: string;
    slug: string;
    description?: string | null;
    processing_time?: string | null;
    visa_fee?: number | null;
    currency?: string | null;
}

const props = withDefaults(
    defineProps<{
        canRegister: boolean;
        featuredTours?: Tour[];
        visaServices?: VisaService[];
        visaCountries?: string[];
        visaTypes?: string[];
    }>(),
    {
        canRegister: true,
        featuredTours: () => [],
        visaServices: () => [],
        visaCountries: () => [],
        visaTypes: () => [],
    },
);
</script>

<template>
    <Head title="Flyover BD - Visa & Tour Management">
        <meta name="description" content="Professional visa assistance and tour management services. Explore amazing destinations with Flyover BD." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        <HeroSearch :visa-countries="visaCountries" :visa-types="visaTypes" />
        <!-- <FeaturesSection /> -->
        <ToursSection :tours="featuredTours" />
        <VisasSection :visa-services="visaServices" />
        <CTASection :can-register="canRegister" />
        <Footer />
        <WhatsAppButton />
    </div>
</template>
