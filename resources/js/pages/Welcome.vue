<script setup lang="ts">
import SeoMeta from '@/components/SeoMeta.vue';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import HeroSearch from '@/components/HomePage/HeroSearch.vue';
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
        featuredTours?: Tour[];
        visaServices?: VisaService[];
        visaCountries?: string[];
        visaTypes?: string[];
        seoMeta?: Record<string, any>;
        organizationSchema?: Record<string, any>;
    }>(),
    {
        featuredTours: () => [],
        visaServices: () => [],
        visaCountries: () => [],
        visaTypes: () => [],
    },
);
</script>

<template>
    <SeoMeta
        :title="seoMeta?.title"
        :description="seoMeta?.description"
        :keywords="seoMeta?.keywords"
        :og-title="seoMeta?.og_title"
        :og-description="seoMeta?.og_description"
        :og-type="seoMeta?.og_type"
        :og-url="seoMeta?.og_url"
        :og-image="seoMeta?.og_image"
        :canonical="seoMeta?.canonical"
        :schema="organizationSchema"
    />

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation />
        <HeroSearch :visa-countries="visaCountries" :visa-types="visaTypes" />
        <ToursSection :tours="featuredTours" />
        <VisasSection :visa-services="visaServices" />
        <CTASection />
        <Footer />
        <WhatsAppButton />
    </div>
</template>
