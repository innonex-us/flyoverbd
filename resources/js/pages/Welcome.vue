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

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
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
        <HeroSearch />
        <FeaturesSection />
        <ToursSection />
        <VisasSection />
        <CTASection :can-register="canRegister" />
        <Footer />
    </div>
</template>
