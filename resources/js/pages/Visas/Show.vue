<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import SeoMeta from '@/components/SeoMeta.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import VisaServiceCard from '@/components/HomePage/VisaServiceCard.vue';
import { Globe, Clock, FileText, CheckCircle, ArrowLeft, Share2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Visa {
    id: number;
    country: string;
    country_code?: string | null;
    slug: string;
    description?: string | null;
    required_documents: string[];
    application_guidelines?: string | null;
    processing_time?: string | null;
    visa_fee?: number | null;
    currency: string;
    eligibility_criteria?: string | null;
    important_notes?: string | null;
}

interface RelatedVisa {
    id: number;
    country: string;
    slug: string;
    description?: string | null;
    visa_fee?: number | null;
    currency: string;
}

interface Props {
    visa: Visa;
    relatedVisas: RelatedVisa[];
    canRegister?: boolean;
    seoMeta?: Record<string, any>;
    visaSchema?: Record<string, any>;
    breadcrumbs?: Array<{ title: string; href?: string }>;
}

const props = withDefaults(defineProps<Props>(), {
    canRegister: true,
});

const guidelinesList = computed(() => {
    if (!props.visa.application_guidelines) return [];
    return props.visa.application_guidelines.split('\n').filter(item => item.trim());
});

const handleShare = () => {
    if (navigator.share) {
        navigator.share({
            title: `${props.visa.country} Visa - Flyover BD`,
            text: props.visa.description || `Complete visa assistance for ${props.visa.country}`,
            url: window.location.href,
        }).catch(() => {
            // User cancelled or error occurred
        });
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copied to clipboard!');
        });
    }
};

const handleApplyNow = () => {
    // Navigate to contact page with visa pre-filled
    router.visit('/contact', {
        query: {
            visa_id: props.visa.id,
            visa_country: props.visa.country,
            subject: `Visa Application for ${props.visa.country}`,
            type: 'visa_application',
        },
    });
};

const handleContactUs = () => {
    router.visit('/contact', {
        query: {
            visa_id: props.visa.id,
            visa_country: props.visa.country,
            subject: `Inquiry about ${props.visa.country} Visa`,
        },
    });
};
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
        :schema="visaSchema"
        :breadcrumbs="breadcrumbs"
    />

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <Link href="/visas" class="mb-6 inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
                <ArrowLeft class="mr-2 h-4 w-4" />
                Back to Visa Services
            </Link>

            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <Card class="bg-white text-gray-900">
                        <CardContent class="p-8">
                            <div class="mb-6 flex items-start justify-between">
                                <div>
                                    <div class="flex items-center space-x-3">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-red-50 to-red-100">
                                            <Globe class="h-8 w-8 text-red-600" />
                                        </div>
                                        <div>
                                            <h1 class="text-3xl font-extrabold text-gray-900">{{ visa.country }} Visa</h1>
                                            <p v-if="visa.country_code" class="mt-1 text-sm text-gray-500">{{ visa.country_code }}</p>
                                        </div>
                                    </div>
                                </div>
                                <Button 
                                    variant="outline" 
                                    size="icon" 
                                    @click="handleShare"
                                    title="Share"
                                >
                                    <Share2 class="h-4 w-4" />
                                </Button>
                            </div>

                            <div v-if="visa.description" class="prose max-w-none">
                                <p class="text-lg text-gray-700 leading-relaxed">{{ visa.description }}</p>
                            </div>

                            <!-- Required Documents -->
                            <div class="mt-8">
                                <h2 class="mb-4 text-2xl font-bold text-gray-900">Required Documents</h2>
                                <div class="space-y-3">
                                    <div 
                                        v-for="(document, index) in visa.required_documents" 
                                        :key="index"
                                        class="flex items-start rounded-lg border border-gray-200 bg-white p-4"
                                    >
                                        <CheckCircle class="mr-3 h-5 w-5 flex-shrink-0 text-green-600" />
                                        <span class="text-gray-700">{{ document }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Application Guidelines -->
                            <div v-if="guidelinesList.length > 0" class="mt-8">
                                <h2 class="mb-4 text-2xl font-bold text-gray-900">Application Guidelines</h2>
                                <div class="space-y-3">
                                    <div 
                                        v-for="(guideline, index) in guidelinesList" 
                                        :key="index"
                                        class="flex items-start"
                                    >
                                        <span class="mr-3 flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-sm font-bold text-red-600">
                                            {{ index + 1 }}
                                        </span>
                                        <span class="text-gray-700">{{ guideline }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Eligibility Criteria -->
                            <div v-if="visa.eligibility_criteria" class="mt-8">
                                <h2 class="mb-4 text-2xl font-bold text-gray-900">Eligibility Criteria</h2>
                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-6">
                                    <p class="whitespace-pre-line text-gray-700">{{ visa.eligibility_criteria }}</p>
                                </div>
                            </div>

                            <!-- Important Notes -->
                            <div v-if="visa.important_notes" class="mt-8">
                                <h2 class="mb-4 text-2xl font-bold text-gray-900">Important Notes</h2>
                                <div class="rounded-lg border border-red-200 bg-red-50 p-6">
                                    <p class="whitespace-pre-line text-gray-700">{{ visa.important_notes }}</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <Card class="sticky top-24 bg-white text-gray-900">
                        <CardContent class="p-6">
                            <div class="mb-6">
                                <div v-if="visa.visa_fee" class="flex items-baseline">
                                    <span class="text-4xl font-extrabold text-red-600">
                                        {{ visa.currency === 'BDT' ? '৳' : visa.currency }} {{ visa.visa_fee.toLocaleString() }}
                                    </span>
                                </div>
                                <p v-else class="text-lg font-semibold text-gray-600">Contact for pricing</p>
                            </div>

                            <div class="space-y-4 border-t border-gray-200 pt-6">
                                <div v-if="visa.processing_time" class="flex items-center justify-between text-sm">
                                    <span class="flex items-center text-gray-600">
                                        <Clock class="mr-2 h-4 w-4" />
                                        Processing Time
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ visa.processing_time }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="flex items-center text-gray-600">
                                        <FileText class="mr-2 h-4 w-4" />
                                        Documents Required
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ visa.required_documents.length }}</span>
                                </div>
                            </div>

                            <Button 
                                class="mt-6 w-full bg-gradient-to-r from-red-600 to-red-700 text-base font-bold text-white shadow-lg transition-all hover:from-red-700 hover:to-red-800 hover:shadow-xl"
                                @click="handleApplyNow"
                            >
                                Apply Now
                            </Button>
                            <Button 
                                variant="outline" 
                                class="mt-3 w-full"
                                @click="handleContactUs"
                            >
                                Contact Us
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <!-- Related Visas -->
            <div v-if="relatedVisas.length > 0" class="mt-16">
                <h2 class="mb-8 text-3xl font-extrabold text-gray-900">Other Visa Services</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <VisaServiceCard
                        v-for="relatedVisa in relatedVisas"
                        :key="relatedVisa.id"
                        :id="relatedVisa.id"
                        :slug="relatedVisa.slug"
                        :icon="Globe"
                        :title="relatedVisa.country"
                        :description="relatedVisa.description || `Complete assistance for ${relatedVisa.country} visa applications`"
                    />
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

